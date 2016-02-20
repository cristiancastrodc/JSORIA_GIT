<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class InstitucionDetalle extends Model
{
    protected $table = 'detalle_institucion';

    /*** Custom ***/
    public $timestamps = false;

    public static function divisiones_institucion($id)
    {
      return InstitucionDetalle::where('id_institucion','=',$id)->get();
    }
}
