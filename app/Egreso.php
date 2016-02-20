<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
  protected $table = 'egreso';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['tipo_comprobante', 'numero_comprobante', 'fecha', 'id_institucion'];

  /*** Custom ***/
  public $timestamps = false;
}
