<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
  protected $table = 'configuracion';

  protected $fillable = ['valor'];

  public $timestamps = false;
}
