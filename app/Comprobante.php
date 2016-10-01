<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;
use JSoria\Institucion;

class Comprobante extends Model
{
  protected $table = 'comprobante';

  protected $fillable = ['tipo', 'serie', 'numero_comprobante', 'pad_izquierda', 'id_institucion'];

  public $timestamps = false;

  /**
   * Recupera los datos del comprobante
   */
  public static function seriesComprobante($tipo_comprobante, $id_institucion)
  {
    /*
    $id_razon_social = Institucion::find($id_institucion)->id_razon_social;
    if ($tipo_comprobante != 'comprobante') {
      return Comprobante::where('tipo', $tipo_comprobante)
                        ->where('id_razon_social', $id_razon_social)
                        ->first();
    } else {
      $serie = ($tipo_impresora == 'matricial' ? 'C001' : 'C002' );
      return Comprobante::where('tipo', $tipo_comprobante)
                        ->where('serie', $serie)
                        ->where('id_razon_social', $id_razon_social)
                        ->first();
    }
    */
    return Comprobante::where('tipo', $tipo_comprobante)
                      ->where('id_institucion', $id_institucion)
                      ->select('serie', 'pad_izquierda', 'numero_comprobante')
                      ->get();
  }
}
