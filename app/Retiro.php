<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Retiro extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'retiro';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['monto', 'fecha_hora', 'estado', 'id_usuario', 'id_cajera'];

  /*** Custom ***/
  public $timestamps = false;

}
