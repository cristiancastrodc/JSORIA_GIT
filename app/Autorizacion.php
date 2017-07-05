<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Autorizacion extends Model
{
  protected $table = 'autorizacion';

  protected $fillable = ['rd','estado','id_alumno','fecha_limite'];

  public static function listar($nro_documento, $fecha_creacion)
  {
    $autorizaciones = Autorizacion::join('alumno', 'autorizacion.id_alumno', '=', 'alumno.nro_documento')
                                  ->select('autorizacion.id', 'rd', 'id_alumno', 'alumno.apellidos', 'alumno.nombres', 'fecha_limite', 'created_at as fecha_creacion', 'autorizacion.estado');
    if ($nro_documento != '') {
      $autorizaciones->where('id_alumno', $nro_documento);
    }
    if ($fecha_creacion != '') {
      $autorizaciones->whereDate('created_at', '=', $fecha_creacion);
    }
    return $autorizaciones->get();
  }
  public static function recuperar($nro_documento, $resolucion)
  {
      return Autorizacion::where('id_alumno', $nro_documento)
                         ->where('rd', $resolucion)
                         ->first();
  }
}
