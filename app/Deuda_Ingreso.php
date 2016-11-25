<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;
use DB;

class Deuda_Ingreso extends Model
{
  protected $table = 'deuda_ingreso';

  protected $fillable = ['saldo', 'descuento', 'estado_pago', 'estado_retiro', 'estado_descuento', 'estado_fraccionam', 'cliente_extr', 'descripcion_extr',
  'fecha_hora_ingreso', 'id_categoria', 'id_alumno', 'id_autorizacion', 'id_retiro', 'id_cajera', 'tipo_comprobante', 'serie_comprobante', 'numero_comprobante'];

  /*** Custom ***/
  public $timestamps = false;

  public static function retiroAdmin($id_cajera)
  {
    return Deuda_Ingreso::join('categoria', 'deuda_ingreso.id_categoria', '=', 'categoria.id')
           ->where('categoria.destino', '=', '1')
           ->where('deuda_ingreso.estado_pago', '=', '1')
           ->where('deuda_ingreso.id_cajera', '=', $id_cajera)
           ->where('deuda_ingreso.estado_retiro', '<>', '2')
           ->select('deuda_ingreso.id', 'deuda_ingreso.fecha_hora_ingreso', 'categoria.nombre', 'deuda_ingreso.estado_retiro', 'deuda_ingreso.saldo', 'deuda_ingreso.descuento')
           ->get();
  }

  public static function retiroTesorera($id_cajera, $id_tesorera)
  {
    return Deuda_Ingreso::join('categoria', 'deuda_ingreso.id_categoria', '=', 'categoria.id')
           ->join('detalle_institucion', 'categoria.id_detalle_institucion', '=', 'detalle_institucion.id')
           ->leftJoin('retiro', 'deuda_ingreso.id_retiro', '=', 'retiro.id')
           ->where('deuda_ingreso.id_cajera', '=', $id_cajera)
           ->where('deuda_ingreso.estado_pago', '=', '1')
           ->where('deuda_ingreso.estado_retiro', '<>', '2')
           ->where('categoria.destino', '=', '0')
           ->whereIn('detalle_institucion.id_institucion', function ($query) use ($id_tesorera) {
              $query->select('id_institucion')
                    ->from('permisos')
                    ->where('id_usuario', $id_tesorera);
           })
           ->where(function ($query) use ($id_tesorera) {
              $query->where('retiro.id_usuario', $id_tesorera)
                    ->orWhereNull('retiro.id');
           })
           ->select('deuda_ingreso.id', 'deuda_ingreso.fecha_hora_ingreso', DB::raw("CONCAT(jsoria_deuda_ingreso.tipo_comprobante, ' ', jsoria_deuda_ingreso.serie_comprobante, '-', jsoria_deuda_ingreso.numero_comprobante) as documento"), 'categoria.nombre', 'deuda_ingreso.estado_retiro', 'deuda_ingreso.saldo', 'deuda_ingreso.descuento')
           ->get();
  }

  /**
   * Devuelve la lista de alumnos por grado/semestre con sus respectivas deudas
   */
  public static function deudasPorGrado($id_grado = '')
  {
    /*
select A.nro_documento,
       alumno = A.nombres + ' ' + A.apellidos,
       C.nombre,
       monto = D.saldo - D.descuento
from deuda_ingreso D
  inner join alumno A
  on D.id_alumno = A.nro_documento
  inner join categoria C
  on D.id_categori = C.id
where estado_pago = '0'
  and A.id_grado = @id_grado
  and A.estado = '1'
      */
  }

  /**
   * Devuelve la lista de ingresos de un día para una cajera
   */
  public static function cajeraIngresosPorDia($id_cajera, $fecha)
  {
    return Deuda_Ingreso::join('categoria', 'deuda_ingreso.id_categoria', '=', 'categoria.id')
                        ->leftJoin('alumno', 'deuda_ingreso.id_alumno', '=', 'alumno.nro_documento')
                        ->leftJoin('grado', 'alumno.id_grado', '=', 'grado.id')
                        ->leftJoin('detalle_institucion', 'grado.id_detalle', '=', 'detalle_institucion.id')
                        ->where('estado_pago', 1)
                        ->whereDate('fecha_hora_ingreso', '=', $fecha)
                        ->where('id_cajera', $id_cajera)
                        ->select(
                          'fecha_hora_ingreso as fecha',
                          DB::raw("IFNULL(CONCAT(jsoria_alumno.nombres, ' ', jsoria_alumno.apellidos), jsoria_deuda_ingreso.cliente_extr) as cliente"),
                          DB::raw("CONCAT(jsoria_grado.nombre_grado, ' ', jsoria_detalle_institucion.nombre_division) as grado"),
                          'categoria.nombre as categoria',
                          DB::raw("CONCAT(jsoria_deuda_ingreso.tipo_comprobante, '-', jsoria_deuda_ingreso.serie_comprobante, '-', jsoria_deuda_ingreso.numero_comprobante) as comprobante"),
                          DB::raw('jsoria_deuda_ingreso.saldo - jsoria_deuda_ingreso.descuento as monto'))
                        ->orderBy('fecha_hora_ingreso', 'asc')
                        ->get();
  }
  /**
   * Devuelve la lista de deudas de alumno
   */
  public static function deudasDeAlumno($nro_documento)
  {
    return Deuda_Ingreso::join('categoria','deuda_ingreso.id_categoria','=','categoria.id')
                        ->where('deuda_ingreso.id_alumno','=', $nro_documento)
                        ->where('deuda_ingreso.estado_pago','=', 0)
                        ->select('deuda_ingreso.id','categoria.nombre','deuda_ingreso.saldo', 'deuda_ingreso.descuento', 'categoria.tipo', 'categoria.fecha_fin', 'deuda_ingreso.estado_descuento', 'deuda_ingreso.estado_fraccionam', 'categoria.destino', 'categoria.monto', 'deuda_ingreso.id_categoria')
                        ->get();
  }
}
