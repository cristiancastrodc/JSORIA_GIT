<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Deuda_Ingreso extends Model
{
  protected $table = 'deuda_ingreso';

  protected $fillable = ['saldo', 'descuento', 'estado_pago', 'estado_retiro', 'estado_descuento', 'estado_fraccionam', 'cliente_extr', 'descripcion_extr',
  'fecha_hora_ingreso', 'id_categoria', 'id_alumno', 'id_autorizacion', 'id_retiro', 'id_cajera'];

  /*** Custom ***/
  public $timestamps = false;

  public static function retiroAdmin($id_cajera)
  {
    return Deuda_Ingreso::join('categoria', 'deuda_ingreso.id_categoria', '=', 'categoria.id')
           ->where('categoria.destino', '=', '1')
           ->where('deuda_ingreso.estado_pago', '=', '1')
           ->where('deuda_ingreso.id_cajera', '=', $id_cajera)
           ->where('deuda_ingreso.estado_retiro', '<>', '2')
           ->select('deuda_ingreso.id', 'deuda_ingreso.fecha_hora_ingreso', 'categoria.nombre', 'deuda_ingreso.estado_retiro', 'deuda_ingreso.saldo', 'deuda_ingreso.descuento')
           ->get();
  }
}
