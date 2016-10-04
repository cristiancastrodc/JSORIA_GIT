<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;
use DB;
use JSoria\Egreso;
use JSoria\IngresoTesorera;
use JSoria\Retiro;

class Balance extends Model {
  protected $table = 'balance';

  protected $fillable = ['fecha', 'id_tesorera', 'ingresos', 'egresos'];

  public $timestamps = false;

  // Método que devuelve el balance de una tesorera para una fecha específica
  public static function getBalanceTesorera($id_tesorera, $fecha)
  {
    $balance = Balance::where('id_tesorera', $id_tesorera)
                      ->orderBy('fecha', 'desc')
                      ->first();
    if (!$balance) {
      // tesorera nueva
      $balance->fecha = date('d-m-Y');
      $balance->saldo_anterior = "0.00";
      $balance->ingresos = "0.00";
      $balance->egresos = "0.00";
      $balance->saldo_actual = "0.00";
    } else {
      // existe registro para la tesorera
      if ($balance->fecha != $fecha) {
        $saldo = number_format(floatval($balance->ingresos) - floatval($balance->egresos), 2);
        $balance->fecha = date('d-m-Y', strtotime($balance->fecha));
        $balance->saldo_anterior = $saldo;
        $balance->ingresos = "0.00";
        $balance->egresos = "0.00";
        $balance->saldo_actual = $saldo;
      }
      else {
        $balance_anterior = Balance::where('id_tesorera', $id_tesorera)
                                   ->orderBy('fecha', 'desc')
                                   ->skip(1)
                                   ->first();
        if (!$balance_anterior) {
          $balance->fecha = date('d-m-Y');
          $balance->saldo_anterior = "0.00";
          $balance->saldo_actual = number_format(floatval($balance->ingresos) - floatval($balance->egresos), 2);
        } else {
          //$saldo_anterior = number_format(floatval($balance_anterior->ingresos) - floatval($balance_anterior->egresos), 2);
          $saldo_anterior = floatval($balance_anterior->ingresos) - floatval($balance_anterior->egresos);
          $ingresos = floatval($balance->ingresos);// - $saldo_anterior;
          $nuevo_ingreso = $ingresos - $saldo_anterior;

          $balance->fecha = $balance_anterior->fecha;
          $balance->saldo_anterior = number_format($saldo_anterior, 2);
          $balance->saldo_actual = number_format(floatval($balance->ingresos) - floatval($balance->egresos), 2);
          $balance->ingresos = number_format($nuevo_ingreso, 2);
        }
      }
    }

    return $balance;
  }

    /*** Recuperar el balance detallado de una tesorera en una fecha específica ***/
  public static function getBalanceDetalladoTesorera($id_tesorera, $fecha)
  {
    $egresos = Egreso::join('detalle_egreso', 'egreso.id', '=', 'detalle_egreso.id_egreso')
                     ->join('tipo_comprobante', 'egreso.tipo_comprobante', '=', 'tipo_comprobante.id')
                     ->select('egreso.fecha_registro as fecha_item', 'tipo_comprobante.denominacion', 'egreso.numero_comprobante', 'detalle_egreso.descripcion', DB::raw("0 as ingreso"), 'detalle_egreso.monto as egreso', DB::raw("'bg-danger' as class"))
                     ->whereDate('egreso.fecha_registro', '=', $fecha)
                     ->where('egreso.id_tesorera', $id_tesorera);
    $adicionales = IngresoTesorera::where('id_tesorera', $id_tesorera)
                                  ->whereDate('created_at', '=', $fecha)
                                  ->select('created_at as fecha_item', DB::raw("'s/d' as denominacion"), DB::raw("'s/d' as numero_comprobante"), DB::raw("'Ingreso Adicional' as descripcion"), 'monto as ingreso', DB::raw('0 as egreso'), DB::raw("'bg-success' as class"));
    $ingresos = Retiro::join('deuda_ingreso', 'retiro.id', '=', 'deuda_ingreso.id_retiro')
                      ->join('categoria', 'deuda_ingreso.id_categoria', '=', 'categoria.id')
                      ->select('deuda_ingreso.fecha_hora_ingreso as fecha_item', 'deuda_ingreso.tipo_comprobante as denominacion', DB::raw("CONCAT(jsoria_deuda_ingreso.serie_comprobante, '-', jsoria_deuda_ingreso.numero_comprobante) as numero_comprobante"), 'categoria.nombre as descripcion', DB::raw('jsoria_deuda_ingreso.saldo - jsoria_deuda_ingreso.descuento as ingreso'), DB::raw("0 as egreso"), DB::raw("'bg-success' as class"))
                      ->whereDate('retiro.fecha_hora_retiro', '=', $fecha)
                      ->where('retiro.id_usuario', $id_tesorera)
                      ->where('retiro.estado', 1)
                      ->union($egresos)
                      ->union($adicionales)
                      ->orderBy('fecha_item')
                      ->get();
    return $ingresos;
  }
}
