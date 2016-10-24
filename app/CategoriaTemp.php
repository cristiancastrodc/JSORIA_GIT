<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class CategoriaTemp extends Model
{
  protected $table = 'categorias_temp';

  protected $fillable = ['id_detalle_institucion', 'estado', 'monto_matricula', 'monto_pension', 'concepto_matricula', 'concepto_pension', 'periodo'];

  /*** Custom ***/
  public $timestamps = false;
}
