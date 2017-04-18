<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class DetalleEgreso extends Model
{
  protected $table = 'detalle_egreso';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['id_egreso', 'nro_detalle_egreso', 'id_rubro', 'monto', 'descripcion'];
  /*** Custom ***/
  public $timestamps = false;
  /**
   * Retornar el detalle asociado a un egreso.
   *
   * @var id_egreso
   */
  public static function detalleDeEgreso($id_egreso)
  {
    return DetalleEgreso::join('rubro', 'detalle_egreso.id_rubro', '=', 'rubro.id')
                        ->select('detalle_egreso.*', 'rubro.nombre as rubro')
                        ->where('id_egreso', $id_egreso)
                        ->get();
  }
}
