<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Usuario_Modulos extends Model
{
  protected $table = 'usuario_modulos';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['id_usuario', 'id_modulo'];
  /*** Custom ***/
  public $timestamps = false;
  /**
   * Retorna la lista de modulos del usuario autenticado
   */
  public static function modulosDeUsuario()
  {
    $id_usuario = Auth::user()->id;
    return Usuario_Modulos::where('id_usuario', $id_usuario)
                          ->join('modulos', 'usuario_modulos.id_modulo', '=', 'modulos.id')
                          ->select('modulos.tag_id')
                          ->get();
  }
}
