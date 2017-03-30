<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Retiro extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'retiro';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['monto', 'fecha_hora_creacion', 'estado', 'id_usuario', 'id_cajera', 'fecha_hora_retiro'];

  /*** Custom ***/
  public $timestamps = false;
  /**
   * Lista de retiros de un usuario.
   */
  public static function retirosUsuario($id_usuario)
  {
    return Retiro::where('id_usuario', $id_usuario)
                 ->join('usuario', 'retiro.id_cajera', '=', 'usuario.id')
                 ->select('retiro.id', 'monto', 'fecha_hora_creacion', 'estado', 'usuario.nombres', 'usuario.apellidos', 'fecha_hora_retiro')
                 ->get();
  }
}
