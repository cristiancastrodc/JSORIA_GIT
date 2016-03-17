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
}
