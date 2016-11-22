<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;
use DB;
use JSoria\Grado;

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
    return Alumno::join('grado', 'alumno.id_grado', '=', 'grado.id' )
           ->where('estado', '=', 1)
           ->where('grado.id_detalle','=', $id_detalle_institucion)
           ->select('alumno.nro_documento')
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
}
