<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
  protected $table = 'rubro';

  protected $fillable = ['nombre'];

  /*** Custom ***/
  public $timestamps = false;
}
