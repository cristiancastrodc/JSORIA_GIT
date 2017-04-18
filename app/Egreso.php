<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Egreso extends Model
{
  protected $table = 'egreso';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['tipo_comprobante', 'numero_comprobante', 'fecha', 'id_institucion', 'id_tesorera', 'fecha_registro', 'razon_social', 'responsable'];

  /*** Custom ***/
  public $timestamps = false;

  /*** Recuperar Lista de Egresos por Fecha ***/
  public static function egresosPorFecha($fecha_egreso)
  {
    $q = Egreso::join('institucion', 'egreso.id_institucion', '=', 'institucion.id')
               ->where('id_tesorera', Auth::user()->id)
               ->select('egreso.id', 'institucion.nombre', 'egreso.tipo_comprobante', 'egreso.numero_comprobante');
    if ($fecha_egreso != '') {
      $q->where('fecha', $fecha_egreso);
    }
    return $q->get();
  }
}
