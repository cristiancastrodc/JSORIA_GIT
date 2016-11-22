<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
  protected $table = 'modulos';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['descripcion', 'tipo_usuario', 'tag_id'];

  /*** Custom ***/
  public $timestamps = false;
}
