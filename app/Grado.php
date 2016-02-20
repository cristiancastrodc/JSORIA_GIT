<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'grado';

  /*** Custom ***/
  public $timestamps = false;
}
