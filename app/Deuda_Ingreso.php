<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

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
           ->select('deuda_ingreso.id', 'deuda_ingreso.fecha_hora_ingreso', 'categoria.nombre', 'deuda_ingreso.estado_retiro', 'deuda_ingreso.saldo', 'deuda_ingreso.descuento')
           ->get();
  }

  /**
   * Devuelve la lista de alumnos por grado/semestre con sus respectivas deudas
   */
  public static function deudasPorGrado($id_grado = '')
  {
    
  }

}
