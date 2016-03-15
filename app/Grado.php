<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

use JSoria\Grado;



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

  public static function grado_divisiones($id_detalle_institucion)
  {
    return Grado::where('id_detalle','=',$id_detalle_institucion)->get();
  }
}

