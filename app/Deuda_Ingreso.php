<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Deuda_Ingreso extends Model
{
  protected $table = 'deuda_ingreso';

  protected $fillable = ['saldo', 'descuento', 'estado_pago', 'estado_retiro', 'estado_descuento', 'estado_fraccionam', 'cliente_extr', 'descripcion_extr',
  'fecha_hora_ingreso', 'id_categoria', 'id_alumno', 'id_autorizacion', 'id_retiro'];

  /*** Custom ***/
  public $timestamps = false;
}
