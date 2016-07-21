<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use Escpos;
use WindowsPrintConnector;
use NumeroALetras;

use JSoria\Alumno;
use JSoria\Comprobante;
use JSoria\Institucion;

class HerramientasController extends Controller
{
  /*** Herramienta de impresión ***/
  public static function imprimirBoletaCompMatricial($nro_documento, $nombre, $pagos, $monto_total, $nombre_impresora)
  {
      $alumno_grado = Alumno::find($nro_documento);
      $alumno_grado = $alumno_grado->id_grado;
      $institucion = Institucion::join('detalle_institucion', 'institucion.id', '=', 'detalle_institucion.id_institucion')
                                ->join('grado', 'detalle_institucion.id', '=', 'grado.id_detalle')
                                ->where('grado.id', $alumno_grado)
                                ->first();
      $fecha = date('d/m/Y H:i:s');
      $monto_total = number_format($monto_total, 2);
      $letras = NumeroALetras::convertir($monto_total, 'soles', 'centimos');

      $tmpdir = sys_get_temp_dir();
      $file =  tempnam($tmpdir, 'ctk');
      $handle = fopen($file, 'w');
      $condensed = Chr(27) . Chr(33) . Chr(4);
      $bold1 = Chr(27) . Chr(69);
      $bold0 = Chr(27) . Chr(70);
      $initialized = chr(27).chr(64);
      $condensed1 = chr(15);
      $condensed0 = chr(18);

      /*** Inicio del Diseño del documento ***/
      $Data  = $initialized;
      $Data .= $condensed1;
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= str_pad("     " . $institucion->nombre, 73) . $institucion->nombre . "\n";
      $Data .= str_pad("      Fecha: " . $fecha, 73) . "Fecha: " . $fecha . "\n";
      $Data .= "\n";
      $Data .= str_pad("                " . $nro_documento, 80) . $nro_documento . "\n";
      $Data .= "\n";
      $Data .= str_pad("                " . $nombre, 80) . $nombre . "\n";
      $Data .= "\n";
      //$Data .= "\n";

      $lineas = 0;
      foreach ($pagos as $pago) {
          if ($lineas < 6) {
              $Data .= str_pad("     " . $pago[0], 40) . str_pad(number_format($pago[1], 2), 35) . str_pad("     " . $pago[0], 40) . number_format($pago[1], 2) . "\n";
          }
          $lineas++;
      }
      for ($i = 6; $i > $lineas; $i--) {
          $Data .= "\n";
      }
      $Data .= str_pad(str_pad($monto_total, 50, ' ', STR_PAD_LEFT), 115) . $monto_total . "\n";
      $Data .= "\n";
      $Data .= str_pad("            " . $letras, 80) . $letras . "\n";
      /*** Fin del Diseño del documento ***/

      fwrite($handle, $Data);
      fclose($handle);
      copy($file, $nombre_impresora);
      unlink($file);
  }

  public static function imprimirFacturaMatricial($nro_documento, $nombre, $pagos, $monto_total, $ruc_cliente, $razon_social, $direccion, $nombre_impresora)
  {
      $tmpdir = sys_get_temp_dir();
      $file =  tempnam($tmpdir, 'ctk');
      $handle = fopen($file, 'w');
      $condensed = Chr(27) . Chr(33) . Chr(4);
      $bold1 = Chr(27) . Chr(69);
      $bold0 = Chr(27) . Chr(70);
      $initialized = chr(27).chr(64);
      $condensed1 = chr(15);
      $condensed0 = chr(18);

      $Data  = $initialized;
      $Data .= $condensed1;
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "                  " . $nro_documento . "\t\t\t\t\t\t\t" . $nro_documento . "\n";
      $Data .= "\n";
      $Data .= "                  " . $nombre . "\t\t\t\t\t" . $nombre . "\n";
      $Data .= "\n";
      $Data .= "\n";

      $lineas = 0;
      foreach ($pagos as $pago) {
          if ($lineas < 6) {
              $Data .= "     " . $pago[0] . "\t\t\t" . number_format($pago[1], 2) . "               " . $pago[0] . "\t\t\t" . number_format($pago[1], 2) . "\n";
          }
          $lineas++;
      }
      for ($i = 6; $i > $lineas; $i--) {
          $Data .= "\n";
      }
      $Data .= "\t\t\t\t\t\t" . number_format($monto_total, 2) . "\n";
      //$numero_letras = HerramientasController::num2letras($monto_total);
      //$Data .= "\t" . $numero_letras . "\n";

      fwrite($handle, $Data);
      fclose($handle);
      copy($file, $nombre_impresora);
      unlink($file);
  }

  public static function imprimirComprobanteTicketera($nro_documento, $nombre_completo, $pagos, $monto_total, $nombre_impresora)
  {
    try {
      $alumno_grado = Alumno::find($nro_documento);
      $alumno_grado = $alumno_grado->id_grado;
      $institucion = Institucion::join('detalle_institucion', 'institucion.id', '=', 'detalle_institucion.id_institucion')
                                ->join('grado', 'detalle_institucion.id', '=', 'grado.id_detalle')
                                ->where('grado.id', $alumno_grado)
                                ->first();
      $fecha = date('d/m/Y H:i:s');
      $comprobante = Comprobante::where('tipo', 'comprobante')
                                ->where('id_razon_social', $institucion->id_razon_social)
                                ->first();
      $nro_comprobante = intval($comprobante->numero_comprobante) + 1;
      $comprobante->numero_comprobante = $nro_comprobante;
      $comprobante->save();
      $monto_total = number_format($monto_total, 2);
      $letras = NumeroALetras::convertir($monto_total, 'soles', 'centimos');

      // Enter the share name for your USB printer here
      //$connector = "Ticketera";
      $connector = new WindowsPrintConnector($nombre_impresora);

      /* Print a "Hello world" receipt" */
      $printer = new Escpos($connector);
      $printer -> setJustification(Escpos::JUSTIFY_CENTER);
      //$printer -> text("Corporacion Educativa J. Soria S.C.R.L.\n");
      $printer -> text($institucion->razon_social . "\n");
      //$printer -> text("RUC: 20490041339\n");
      $printer -> text("RUC: " . $institucion->ruc . "\n");
      $printer -> text("Jr. Quillabamba N°110\n");
      $printer -> text("Santa Ana - La Convención Cusco\n");
      $printer -> text("=======================================\n");
      $printer -> text($institucion->nombre . "\n");
      $printer -> text($fecha . "\n");
      $printer -> text("Ticket Nro. " . str_pad($nro_comprobante, 6, '0', STR_PAD_LEFT) . "\n");
      $printer -> text("=======================================\n");
      $printer -> setJustification(Escpos::JUSTIFY_LEFT);
      $printer -> text('Nro. de Documento: ' . $nro_documento . "\n");
      $printer -> text('Alumno: ' . $nombre_completo . "\n");
      $printer -> text("=======================================\n");
      foreach ($pagos as $pago) {
        $concepto = str_pad(substr($pago[0], 0, 30), 30);
        $monto = str_pad(number_format($pago[1], 2), 10, ' ', STR_PAD_LEFT);
        $printer -> text($concepto);
        $printer -> text($monto . "\n");
      }
      $printer -> setJustification(Escpos::JUSTIFY_RIGHT);
      $printer -> text("-------\n");
      $printer -> text("TOTAL: " . $monto_total . "\n");
      $printer -> text("SON: " . $letras . "\n");
      $printer -> text("=======================================\n");
      $printer -> setJustification(Escpos::JUSTIFY_CENTER);
      $printer -> text("Marca Convenciana. ¡¡SIEMPRE ADELANTE!!\n");
      $printer -> cut();

      /* Close printer */
      $printer -> close();
    } catch(Exception $e) {
      return "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    }
  }

  public static function imprimirBoletaCompMatricialExtr($nombre_completo, $descripcion, $monto_total, $nombre_impresora)
  {
      $fecha = date('d/m/Y H:i:s');
      $monto_total = number_format($monto_total, 2);
      $letras = NumeroALetras::convertir($monto_total, 'soles', 'centimos');

      $tmpdir = sys_get_temp_dir();
      $file =  tempnam($tmpdir, 'ctk');
      $handle = fopen($file, 'w');
      $condensed = Chr(27) . Chr(33) . Chr(4);
      $bold1 = Chr(27) . Chr(69);
      $bold0 = Chr(27) . Chr(70);
      $initialized = chr(27).chr(64);
      $condensed1 = chr(15);
      $condensed0 = chr(18);

      $Data  = $initialized;
      $Data .= $condensed1;
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= str_pad("      Fecha: " . $fecha, 73) . "Fecha: " . $fecha . "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= str_pad("                " . $nombre_completo, 80) . $nombre_completo . "\n";
      $Data .= "\n";

      $Data .= str_pad("     " . $descripcion, 40) . str_pad($monto_total, 35) . str_pad("     " . $descripcion, 40) . $monto_total . "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";

      $Data .= str_pad(str_pad($monto_total, 50, ' ', STR_PAD_LEFT), 115) . $monto_total . "\n";
      $Data .= "\n";
      $Data .= str_pad("            " . $letras, 80) . $letras . "\n";
      fwrite($handle, $Data);
      fclose($handle);
      copy($file, $nombre_impresora);
      unlink($file);
  }

  public static function imprimirFacturaMatricialExtr($nombre_completo, $descripcion, $monto_total, $ruc_cliente, $razon_social, $direccion, $nombre_impresora)
  {
      $fecha = date('d/m/Y H:i:s');
      $monto_total = number_format($monto_total, 2);
      $letras = NumeroALetras::convertir($monto_total, 'soles', 'centimos');

      $tmpdir = sys_get_temp_dir();
      $file =  tempnam($tmpdir, 'ctk');
      $handle = fopen($file, 'w');
      $condensed = Chr(27) . Chr(33) . Chr(4);
      $bold1 = Chr(27) . Chr(69);
      $bold0 = Chr(27) . Chr(70);
      $initialized = chr(27).chr(64);
      $condensed1 = chr(15);
      $condensed0 = chr(18);

      $Data  = $initialized;
      $Data .= $condensed1;
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= str_pad("      Fecha: " . $fecha, 73) . "Fecha: " . $fecha . "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= str_pad("                " . $nombre_completo, 80) . $nombre_completo . "\n";
      $Data .= "\n";

      $Data .= str_pad("     " . $descripcion, 40) . str_pad($monto_total, 35) . str_pad("     " . $descripcion, 40) . $monto_total . "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";

      $Data .= str_pad(str_pad($monto_total, 50, ' ', STR_PAD_LEFT), 115) . $monto_total . "\n";
      $Data .= "\n";
      $Data .= str_pad("            " . $letras, 80) . $letras . "\n";
      fwrite($handle, $Data);
      fclose($handle);
      copy($file, $nombre_impresora);
      unlink($file);
  }

  public static function imprimirComprobanteTicketeraExtr($nombre_completo, $descripcion, $monto_total, $institucion, $nombre_impresora)
  {
    try {
      $fecha = date('d/m/Y H:i:s');
      $comprobante = Comprobante::where('tipo', 'comprobante')
                                ->where('id_razon_social', $institucion->id_razon_social)
                                ->first();
      $nro_comprobante = intval($comprobante->numero_comprobante) + 1;
      $comprobante->numero_comprobante = $nro_comprobante;
      $comprobante->save();
      $monto_total = number_format($monto_total, 2);
      $letras = NumeroALetras::convertir($monto_total, 'soles', 'centimos');

      // Enter the share name for your USB printer here
      //$connector = "Ticketera";
      $connector = new WindowsPrintConnector($nombre_impresora);

      /* Print a "Hello world" receipt" */
      $printer = new Escpos($connector);
      $printer -> setJustification(Escpos::JUSTIFY_CENTER);
      //$printer -> text("Corporacion Educativa J. Soria S.C.R.L.\n");
      //$printer -> text("RUC: 20490041339\n");
      $printer -> text($institucion->razon_social . "\n");
      $printer -> text("RUC: " . $institucion->ruc . "\n");
      $printer -> text("Jr. Quillabamba N°110\n");
      $printer -> text("Santa Ana - La Convención Cusco\n");
      $printer -> text("=======================================\n");
      //$printer -> text($institucion->nombre . "\n");
      $printer -> text($fecha . "\n");
      $printer -> text("Ticket Nro. " . str_pad($nro_comprobante, 6, '0', STR_PAD_LEFT) . "\n");
      $printer -> text("=======================================\n");
      $printer -> setJustification(Escpos::JUSTIFY_LEFT);
      $printer -> text('Cliente: ' . $nombre_completo . "\n");
      $printer -> text("=======================================\n");
      $concepto = str_pad(substr($descripcion, 0, 30), 30);
      $monto = str_pad($monto_total, 10, ' ', STR_PAD_LEFT);
      $printer -> text($concepto);
      $printer -> text($monto . "\n");
      $printer -> setJustification(Escpos::JUSTIFY_RIGHT);
      $printer -> text("-------\n");
      $printer -> text("TOTAL: " . $monto_total . "\n");
      $printer -> text("SON: " . $letras . "\n");
      $printer -> text("=======================================\n");
      $printer -> setJustification(Escpos::JUSTIFY_CENTER);
      $printer -> text("Marca Convenciana. ¡¡SIEMPRE ADELANTE!!\n");
      $printer -> cut();

      /* Close printer */
      $printer -> close();
    } catch(Exception $e) {
      return "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    }
  }

  public static function imprimirBoletaCompMatricialMultiple($dni, $nombre, $categoria, $nombre_impresora)
  {
      $fecha = date('d/m/Y H:i:s');

      $monto_total = number_format($categoria->monto, 2);
      $letras = NumeroALetras::convertir($monto_total, 'soles', 'centimos');

      $institucion = Institucion::join('detalle_institucion', 'institucion.id', '=', 'detalle_institucion.id_institucion')
                                ->where('detalle_institucion.id', $categoria->id_detalle_institucion)
                                ->first();

      $tmpdir = sys_get_temp_dir();
      $file =  tempnam($tmpdir, 'ctk');
      $handle = fopen($file, 'w');
      $condensed = Chr(27) . Chr(33) . Chr(4);
      $bold1 = Chr(27) . Chr(69);
      $bold0 = Chr(27) . Chr(70);
      $initialized = chr(27).chr(64);
      $condensed1 = chr(15);
      $condensed0 = chr(18);

      /*** Inicio del Diseño del documento ***/
      $Data  = $initialized;
      $Data .= $condensed1;
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= str_pad("     " . $institucion->nombre, 73) . $institucion->nombre . "\n";
      $Data .= str_pad("      Fecha: " . $fecha, 73) . "Fecha: " . $fecha . "\n";
      $Data .= "\n";
      $Data .= str_pad("                " . $dni, 80) . $dni . "\n";
      $Data .= "\n";
      $Data .= str_pad("                " . $nombre, 80) . $nombre . "\n";
      $Data .= "\n";

      $Data .= str_pad("     " . $categoria->nombre, 40) . str_pad($monto_total, 35) . str_pad("     " . $categoria->nombre, 40) . $monto_total . "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";

      $Data .= str_pad(str_pad($monto_total, 50, ' ', STR_PAD_LEFT), 115) . $monto_total . "\n";
      $Data .= "\n";
      $Data .= str_pad("            " . $letras, 80) . $letras . "\n";
      /*** Fin del Diseño del documento ***/

      fwrite($handle, $Data);
      fclose($handle);
      copy($file, $nombre_impresora);
      unlink($file);
  }

  public static function imprimirFacturaMatricialMultiple($ruc_cliente, $razon_social, $direccion, $categoria, $nombre_impresora)
  {
      $fecha = date('d/m/Y H:i:s');

      $monto_total = number_format($categoria->monto, 2);
      $letras = NumeroALetras::convertir($monto_total, 'soles', 'centimos');

      $institucion = Institucion::join('detalle_institucion', 'institucion.id', '=', 'detalle_institucion.id_institucion')
                                ->where('detalle_institucion.id', $categoria->id_detalle_institucion)
                                ->first();

      $tmpdir = sys_get_temp_dir();
      $file =  tempnam($tmpdir, 'ctk');
      $handle = fopen($file, 'w');
      $condensed = Chr(27) . Chr(33) . Chr(4);
      $bold1 = Chr(27) . Chr(69);
      $bold0 = Chr(27) . Chr(70);
      $initialized = chr(27).chr(64);
      $condensed1 = chr(15);
      $condensed0 = chr(18);

      /*** Inicio del Diseño del documento ***/
      $Data  = $initialized;
      $Data .= $condensed1;
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= str_pad("     " . $institucion->nombre, 73) . $institucion->nombre . "\n";
      $Data .= str_pad("      Fecha: " . $fecha, 73) . "Fecha: " . $fecha . "\n";
      $Data .= "\n";
      $Data .= str_pad("                " . $ruc_cliente, 80) . $ruc_cliente . "\n";
      $Data .= "\n";
      $Data .= str_pad("                " . $razon_social, 80) . $razon_social . "\n";
      $Data .= "\n";

      $Data .= str_pad("     " . $categoria->nombre, 40) . str_pad($monto_total, 35) . str_pad("     " . $categoria->nombre, 40) . $monto_total . "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";
      $Data .= "\n";

      $Data .= str_pad(str_pad($monto_total, 50, ' ', STR_PAD_LEFT), 115) . $monto_total . "\n";
      $Data .= "\n";
      $Data .= str_pad("            " . $letras, 80) . $letras . "\n";
      /*** Fin del Diseño del documento ***/

      fwrite($handle, $Data);
      fclose($handle);
      copy($file, $nombre_impresora);
      unlink($file);
  }

  public static function imprimirComprobanteTicketeraMultiple($dni, $nombre, $categoria, $nombre_impresora)
  {
    try {
      $fecha = date('d/m/Y H:i:s');
      $institucion = Institucion::join('detalle_institucion', 'institucion.id', '=', 'detalle_institucion.id_institucion')
                                ->where('detalle_institucion.id', $categoria->id_detalle_institucion)
                                ->first();
      $id_razon_social = $institucion->id_razon_social;

      $comprobante = Comprobante::where('tipo', 'comprobante')
                                ->where('id_razon_social', $id_razon_social)
                                ->first();

      $nro_comprobante = intval($comprobante->numero_comprobante) + 1;
      $comprobante->numero_comprobante = $nro_comprobante;
      $comprobante->save();
      $monto_total = number_format($categoria->monto, 2);
      $letras = NumeroALetras::convertir($monto_total, 'soles', 'centimos');

      // Enter the share name for your USB printer here
      //$connector = "Ticketera";
      $connector = new WindowsPrintConnector($nombre_impresora);

      $printer = new Escpos($connector);
      $printer -> setJustification(Escpos::JUSTIFY_CENTER);
      //$printer -> text("Corporacion Educativa J. Soria S.C.R.L.\n");
      //$printer -> text("RUC: 20490041339\n");
      $printer -> text($institucion->razon_social . "\n");
      $printer -> text("RUC: " . $institucion->ruc . "\n");
      $printer -> text("Jr. Quillabamba N°110\n");
      $printer -> text("Santa Ana - La Convención Cusco\n");
      $printer -> text("=======================================\n");
      //$printer -> text($institucion->nombre . "\n");
      $printer -> text($fecha . "\n");
      $printer -> text("Ticket Nro. " . str_pad($nro_comprobante, 6, '0', STR_PAD_LEFT) . "\n");
      $printer -> text("=======================================\n");
      $printer -> setJustification(Escpos::JUSTIFY_LEFT);
      $printer -> text('Cliente: ' . $nombre . "\n");
      $printer -> text("=======================================\n");
      $concepto = str_pad(substr($categoria->nombre, 0, 30), 30);
      $monto = str_pad($monto_total, 10, ' ', STR_PAD_LEFT);
      $printer -> text($concepto);
      $printer -> text($monto . "\n");
      $printer -> setJustification(Escpos::JUSTIFY_RIGHT);
      $printer -> text("-------\n");
      $printer -> text("TOTAL: " . $monto_total . "\n");
      $printer -> text("SON: " . $letras . "\n");
      $printer -> text("=======================================\n");
      $printer -> setJustification(Escpos::JUSTIFY_CENTER);
      $printer -> text("Marca Convenciana. ¡¡SIEMPRE ADELANTE!!\n");
      $printer -> cut();

      /* Close printer */
      $printer -> close();
    } catch(Exception $e) {
      return "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    }
  }
}
