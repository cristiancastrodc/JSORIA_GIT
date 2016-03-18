<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

class HerramientasController extends Controller
{
  /*** Herramienta de impresión ***/
  public static function imprimir($nro_documento, $nombre, $pagos, $monto_total)
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
      copy($file, "//localhost/EpsonLX350");
      unlink($file);
  }

  public static function num2letras($num, $fem = false, $dec = true) {
     $matuni[2]  = "dos";
     $matuni[3]  = "tres";
     $matuni[4]  = "cuatro";
     $matuni[5]  = "cinco";
     $matuni[6]  = "seis";
     $matuni[7]  = "siete";
     $matuni[8]  = "ocho";
     $matuni[9]  = "nueve";
     $matuni[10] = "diez";
     $matuni[11] = "once";
     $matuni[12] = "doce";
     $matuni[13] = "trece";
     $matuni[14] = "catorce";
     $matuni[15] = "quince";
     $matuni[16] = "dieciseis";
     $matuni[17] = "diecisiete";
     $matuni[18] = "dieciocho";
     $matuni[19] = "diecinueve";
     $matuni[20] = "veinte";
     $matunisub[2] = "dos";
     $matunisub[3] = "tres";
     $matunisub[4] = "cuatro";
     $matunisub[5] = "quin";
     $matunisub[6] = "seis";
     $matunisub[7] = "sete";
     $matunisub[8] = "ocho";
     $matunisub[9] = "nove";

     $matdec[2] = "veint";
     $matdec[3] = "treinta";
     $matdec[4] = "cuarenta";
     $matdec[5] = "cincuenta";
     $matdec[6] = "sesenta";
     $matdec[7] = "setenta";
     $matdec[8] = "ochenta";
     $matdec[9] = "noventa";
     $matsub[3]  = 'mill';
     $matsub[5]  = 'bill';
     $matsub[7]  = 'mill';
     $matsub[9]  = 'trill';
     $matsub[11] = 'mill';
     $matsub[13] = 'bill';
     $matsub[15] = 'mill';
     $matmil[4]  = 'millones';
     $matmil[6]  = 'billones';
     $matmil[7]  = 'de billones';
     $matmil[8]  = 'millones de billones';
     $matmil[10] = 'trillones';
     $matmil[11] = 'de trillones';
     $matmil[12] = 'millones de trillones';
     $matmil[13] = 'de trillones';
     $matmil[14] = 'billones de trillones';
     $matmil[15] = 'de billones de trillones';
     $matmil[16] = 'millones de billones de trillones';

     //Zi hack
     $float=explode('.',$num);
     $num=$float[0];

     $num = trim((string)@$num);
     if ($num[0] == '-') {
        $neg = 'menos ';
        $num = substr($num, 1);
     }else
        $neg = '';
     while ($num[0] == '0') $num = substr($num, 1);
     if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
     $zeros = true;
     $punt = false;
     $ent = '';
     $fra = '';
     for ($c = 0; $c < strlen($num); $c++) {
        $n = $num[$c];
        if (! (strpos(".,'''", $n) === false)) {
           if ($punt) break;
           else{
              $punt = true;
              continue;
           }

        }elseif (! (strpos('0123456789', $n) === false)) {
           if ($punt) {
              if ($n != '0') $zeros = false;
              $fra .= $n;
           }else

              $ent .= $n;
        }else

           break;

     }
     $ent = '     ' . $ent;
     if ($dec and $fra and ! $zeros) {
        $fin = ' coma';
        for ($n = 0; $n < strlen($fra); $n++) {
           if (($s = $fra[$n]) == '0')
              $fin .= ' cero';
           elseif ($s == '1')
              $fin .= $fem ? ' una' : ' un';
           else
              $fin .= ' ' . $matuni[$s];
        }
     }else
        $fin = '';
     if ((int)$ent === 0) return 'Cero ' . $fin;
     $tex = '';
     $sub = 0;
     $mils = 0;
     $neutro = false;
     while ( ($num = substr($ent, -3)) != '   ') {
        $ent = substr($ent, 0, -3);
        if (++$sub < 3 and $fem) {
           $matuni[1] = 'una';
           $subcent = 'as';
        }else{
           $matuni[1] = $neutro ? 'un' : 'uno';
           $subcent = 'os';
        }
        $t = '';
        $n2 = substr($num, 1);
        if ($n2 == '00') {
        }elseif ($n2 < 21)
           $t = ' ' . $matuni[(int)$n2];
        elseif ($n2 < 30) {
           $n3 = $num[2];
           if ($n3 != 0) $t = 'i' . $matuni[$n3];
           $n2 = $num[1];
           $t = ' ' . $matdec[$n2] . $t;
        }else{
           $n3 = $num[2];
           if ($n3 != 0) $t = ' y ' . $matuni[$n3];
           $n2 = $num[1];
           $t = ' ' . $matdec[$n2] . $t;
        }
        $n = $num[0];
        if ($n == 1) {
           $t = ' ciento' . $t;
        }elseif ($n == 5){
           $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
        }elseif ($n != 0){
           $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
        }
        if ($sub == 1) {
        }elseif (! isset($matsub[$sub])) {
           if ($num == 1) {
              $t = ' mil';
           }elseif ($num > 1){
              $t .= ' mil';
           }
        }elseif ($num == 1) {
           $t .= ' ' . $matsub[$sub] . '?n';
        }elseif ($num > 1){
           $t .= ' ' . $matsub[$sub] . 'ones';
        }
        if ($num == '000') $mils ++;
        elseif ($mils != 0) {
           if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
           $mils = 0;
        }
        $neutro = true;
        $tex = $t . $tex;
     }
     $tex = $neg . substr($tex, 1) . $fin;
     //Zi hack --> return ucfirst($tex);
     $end_num=ucfirst($tex).' soles '.$float[1].'/100 N.S.';
     return $end_num;
  }
}
