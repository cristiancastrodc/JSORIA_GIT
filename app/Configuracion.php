<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
  protected $table = 'configuracion';

  protected $fillable = ['variable', 'valor'];

  public $timestamps = false;

  /**
   * Recuperar el valor de una variable de configuracion.
   * En caso no exista la variable, se creará una nueva con el valor por defecto.
   */
  public static function valor($variable, $valor_por_defecto)
  {
    $config = Configuracion::where('variable', $variable)->first();
    if ($config) {
      return $config->valor;
    } else {
      $config = Configuracion::create([ 'variable' => $variable, 'valor' => $valor_por_defecto ]);
      return $config->valor;
    }
  }
  /**
   * Recuperar configuracion
   */
  public static function configuracion($variable)
  {
    return Configuracion::where('variable', $variable)->first();
  }
  /**
   * Actualizar configuracion
   */
  public static function actualizar($variable, $valor)
  {
    $config = Configuracion::configuracion($variable);
    $config->valor = $valor;
    $config->save();
  }
}
