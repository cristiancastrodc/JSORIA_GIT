<?php

namespace JSoria;

use DB;
use Illuminate\Database\Eloquent\Model;
use JSoria\Grado;
use JSoria\Deuda_Ingreso;

class Alumno extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'alumno';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['tipo_documento','nro_documento', 'nombres', 'apellidos', 'estado', 'id_grado'];

  /**
   * The primary key.
   *
   * @var string
   */
  protected $primaryKey = 'nro_documento';

  /*** Custom ***/
  public $timestamps = false;

  public static function datos_alumno($nro_documento)
  {
    return Alumno::where('nro_documento', '=', $nro_documento)->first();
  }

  public static function alumnos_detalle_institucion($id_detalle_institucion)
  {
    return Alumno::join('grado', 'alumno.id_grado', '=', 'grado.id')
                 ->leftJoin('categoria', 'alumno.id_matricula', '=', 'categoria.id')
                 ->where('estado', '=', 1)
                 ->where('grado.id_detalle','=', $id_detalle_institucion)
                 ->select('alumno.nro_documento', 'categoria.periodo')
                 ->get();
  }
  /**
   * Retorna los datos de un alumno específico.
   */
  public static function datosAlumno($nro_documento)
  {
    return Alumno::find($nro_documento);
  }
  /**
   * Retorna los resultados de una búsqueda
   */
  public static function busqueda($texto)
  {
    return Alumno::where('nombres', 'like', $texto)
                 ->orWhere('apellidos', 'like', $texto)
                 ->leftJoin('grado', 'alumno.id_grado', '=', 'grado.id')
                 ->leftJoin('detalle_institucion', 'grado.id_detalle', '=', 'detalle_institucion.id')
                 ->leftJoin('institucion', 'detalle_institucion.id_institucion', '=', 'institucion.id')
                 ->select('alumno.nro_documento', 'alumno.nombres', 'alumno.apellidos', 'institucion.nombre as institucion', 'detalle_institucion.nombre_division as nivel', 'grado.nombre_grado as grado')
                 ->get();
  }
  /**
   * Retorna los alumnos para la creación de deudas de actividad
   */
  public static function alumnosParaCreacionActividades($id_detalle_institucion, $monto, $id_categoria)
  {
    $monto_aux = $monto . ' as saldo';
    $categoria = $id_categoria . ' as id_categoria';
    $alumnos = Alumno::join('grado', 'alumno.id_grado', '=', 'grado.id')
                     ->where('alumno.estado', '=', 1)
                     ->where('grado.id_detalle','=', $id_detalle_institucion)
                     ->select('alumno.nro_documento as id_alumno', 'alumno.id_matricula', DB::raw($monto_aux), DB::raw($categoria))
                     ->get();
    return $alumnos->toArray();
  }
  /**
   * Retorna los alumnos para la creación de deudas de actividad
   */
  public static function periodosAlumno($nro_documento)
  {
    return Deuda_Ingreso::where('id_alumno', $nro_documento)
                        ->join('categoria', 'deuda_ingreso.id_categoria', '=', 'categoria.id')
                        ->join('alumno', 'deuda_ingreso.id_alumno', '=', 'alumno.nro_documento')
                        ->where('categoria.tipo', 'matricula')
                        ->select('categoria.id', 'categoria.periodo')
                        ->distinct()
                        ->get();
  }
  /**
   * Retorna la cuenta de un alumno
   */
  public static function cuentaAlumno($nro_documento, $id_categoria)
  {
    return Deuda_Ingreso::where('id_alumno', $nro_documento)
                        ->join('categoria', 'deuda_ingreso.id_categoria', '=', 'categoria.id')
                        ->where('deuda_ingreso.id_matricula', $id_categoria)
                        ->select('categoria.nombre', 'categoria.tipo','categoria.fecha_fin', 'deuda_ingreso.estado_pago','deuda_ingreso.fecha_hora_ingreso', 'deuda_ingreso.tipo_comprobante','deuda_ingreso.serie_comprobante', 'deuda_ingreso.numero_comprobante', 'deuda_ingreso.saldo', 'deuda_ingreso.descuento')
                        ->get();
  }
  /**
   * Retorna las deudas de un alumno
   */
  public static function deudasAlumno($nro_documento)
  {
    return Deuda_Ingreso::where('id_alumno', $nro_documento)
                        ->join('categoria', 'deuda_ingreso.id_categoria', '=', 'categoria.id')
                        ->where('deuda_ingreso.estado_pago', '=', 0)
                        ->select('categoria.nombre', 'categoria.tipo', 'categoria.fecha_fin', 'deuda_ingreso.saldo', 'deuda_ingreso.descuento', 'categoria.periodo')
                        ->get();
  }
  /**
   * Retorna los alumnos deudores de un determinado grado o semestre
   */
  public static function alumnosDeudores($grado)
  {
    $hoy = date('Y-m-d');

    $deudas = Alumno::where('id_grado', $grado)
                 ->join('deuda_ingreso', 'alumno.nro_documento', '=', 'deuda_ingreso.id_alumno')
                 ->join('categoria', 'deuda_ingreso.id_categoria', '=', 'categoria.id')
                 ->where('deuda_ingreso.estado_pago', '=', 0)
                 ->where('categoria.tipo', '=', 'pension')
                 ->where('categoria.fecha_fin', '<', $hoy)
                 ->select('alumno.nro_documento', 'alumno.nombres', 'alumno.apellidos', 'categoria.nombre', 'categoria.fecha_fin', 'deuda_ingreso.saldo', 'deuda_ingreso.descuento');

    $deudas2 = Alumno::where('id_grado', $grado)
                 ->join('deuda_ingreso', 'alumno.nro_documento', '=', 'deuda_ingreso.id_alumno')
                 ->join('categoria', 'deuda_ingreso.id_categoria', '=', 'categoria.id')
                 ->where('deuda_ingreso.estado_pago', '=', 0)
                 ->where('categoria.tipo', '<>', 'pension')
                 ->select('alumno.nro_documento', 'alumno.nombres', 'alumno.apellidos', 'categoria.nombre', DB::raw("'' as fecha_fin"), 'deuda_ingreso.saldo', 'deuda_ingreso.descuento')
                 ->union($deudas)
                 ->get();
    return $deudas2;
  }
  /**
   * Retorna un alumno junto a su institución
   */
  public static function recuperarAlumno($nro_documento)
  {
    return Alumno::join('grado', 'alumno.id_grado', '=', 'grado.id')
                 ->join('detalle_institucion', 'grado.id_detalle', '=', 'detalle_institucion.id')
                 ->join('institucion', 'detalle_institucion.id_institucion', '=', 'institucion.id')
                 ->where('alumno.nro_documento', $nro_documento)
                 ->select('alumno.nombres', 'alumno.apellidos', 'institucion.nombre as institucion', 'detalle_institucion.nombre_division as division', 'institucion.id as id_institucion', 'grado.nombre_grado as grado')
                 ->first();
  }
  /**
   * Retornar los datos de un alumno.
   */
  public static function recuperarDatosAlumno($nro_documento)
  {
    return Alumno::leftJoin('grado', 'alumno.id_grado', '=', 'grado.id')
                 ->leftJoin('detalle_institucion', 'grado.id_detalle', '=', 'detalle_institucion.id')
                 ->leftJoin('institucion', 'detalle_institucion.id_institucion', '=', 'institucion.id')
                 ->where('alumno.nro_documento', $nro_documento)
                 ->select('nro_documento', DB::raw("CONCAT(jsoria_alumno.apellidos, ', ', jsoria_alumno.nombres) as nombre"), DB::raw("CONCAT(jsoria_institucion.nombre, ' - ', jsoria_detalle_institucion.nombre_division, ' - ', jsoria_grado.nombre_grado) as institucion"))
                 ->first();
  }
}
