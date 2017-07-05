<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;
use JSoria\Alumno;
use JSoria\Deuda_Ingreso;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

class ReportesSecretariaController extends Controller
{
  /**
   * Mostrar el reporte de Deudas por Grado
   */
  public function deudasPorGrado()
  {
    return view('secretaria.reportes.deudas');
  }

  /**
   * Procesar el reporte de Deudas por Grado
   */
  public function procesarDeudasPorGrado(Request $request)
  {
    $deudas = Deuda_Ingreso::deudasPorGrado($request['grado']);
    return 'hola';
  }
  /**
   * Recuperar los períodos del alumno
   */
  public function periodosAlumno($nro_documento)
  {
    $respuesta = [];
    $alumno = Alumno::datosAlumno($nro_documento);
    if ($alumno) {
      $periodos = Alumno::periodosAlumno($nro_documento);
      $respuesta['alumno'] = $alumno;
      $respuesta['periodos'] = $periodos;
      $respuesta['resultado'] = 'true';
    } else {
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = 'Alumno no registrado.';
    }
    return $respuesta;
  }
  /**
   * Mostrar la pantalla del Reporte de Cuenta de Alumno
   */
  public function cuentaDeAlumno()
  {
    return view('secretaria.reportes.index');
  }
  /**
   * Mostrar la pantalla de Lista de Ingresos por Cajera
   */
  public function procesarCuentaDeAlumno(Request $request)
  {
    $nro_documento = $request->nro_documento;
    $id_categoria = $request->id_categoria;
    $periodo = $request->periodo;
    $tipo_reporte = $request->tipo_reporte;
    // Recuperar valores enviados y de la base de datos
    $fecha_archivo = date('d-m-Y H:i:s');
    $archivo = 'Reporte de Cuenta de Alumno -' . $nro_documento . '-' . $fecha_archivo;
    $cuenta = Alumno::cuentaAlumno($nro_documento, $id_categoria);
    $alumno = Alumno::datosAlumno($nro_documento);
    $fecha = date('d-m-Y');
    // Generar el PDF
    if ($tipo_reporte == 'pdf') {
      $view = \View::make('admin.reportes.cuenta_alumno_rept',
                          ['cuenta' => $cuenta, 'alumno' => $alumno, 'fecha' => $fecha, 'periodo' => $periodo]
                         )->render();
      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($view);
      return $pdf->stream($archivo);
    } else {
      \Excel::create($archivo, function($excel) use ($cuenta, $alumno, $fecha, $periodo) {
        $excel->sheet('Hoja 1', function($sheet) use ($cuenta, $alumno, $fecha, $periodo) {
          $sheet->loadView('admin.reportes.cuenta_alumno_rept', array(
            'cuenta' => $cuenta,
            'alumno' => $alumno,
            'fecha' => $fecha,
            'periodo' => $periodo,
          ));
        });
      })->download('xls');
    }
  }
}
