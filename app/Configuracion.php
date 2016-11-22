<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
  protected $table = 'configuracion';

  protected $fillable = ['valor'];

  public $timestamps = false;

  /**
   * Recuperar variable de configuracion
   */
  public static function valor($variable)
  {
    return Configuracion::where('variable', $variable)->first()->valor;
  }
  /**
   * Recuperar configuracion
   */
  public static function configuracion($variable)
  {
    return Configuracion::where('variable', $variable)->first();
  }
}
