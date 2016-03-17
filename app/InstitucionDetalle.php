<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

use JSoria\Grado;

class InstitucionDetalle extends Model
{
    protected $table = 'detalle_institucion';

    /*** Custom ***/
    public $timestamps = false;

    public static function divisiones_institucion($id)
    {
      return InstitucionDetalle::where('id_institucion','=',$id)->get();
    }

    public static function grados_detalle($id)
    {
      return Grado::where('id_detalle','=',$id)->get();
    }
    public static function matricula($id)
    {
      return Categoria::where('id_detalle_institucion','=',$id)
      					-> where('estado', '=', 1)
      					-> where('tipo', '=', 'matricula')
      					->get();
    }
}
