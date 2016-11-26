<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;
use JSoria\Deuda_Ingreso;
use JSoria\Alumno;
use JSoria\Usuario_Modulos;

class ReportesSecretariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Mostrar el reporte de Deudas por Grado
     */
    public function deudasPorGrado()
    {
        $modulos = Usuario_Modulos::modulosDeUsuario();
        return view('secretaria.reportes.deudas', ['modulos' => $modulos]);

        //return view('secretaria.reportes.deudas');
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
      $alumno = Alumno::datosAlumno($nro_documento);
      $periodos = Alumno::periodosAlumno($nro_documento);
      $respuesta = array('alumno' => $alumno, 'periodos' => $periodos);
      return $respuesta;
    }
    /**
     * Mostrar la pantalla de Lista de Ingresos por Cajera
     */
    public function cuentaDeAlumno()
    {
      $modulos = Usuario_Modulos::modulosDeUsuario();
      return view('secretaria.reportes.index',
        ['modulos' => $modulos]
      );
    }
    /**
     * Mostrar la pantalla de Lista de Ingresos por Cajera
     */
    public function procesarCuentaDeAlumno(Request $request)
    {
      $nro_documento = $request->nro_documento;
      $id_categoria = $request->id_categoria;
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
          ['cuenta' => $cuenta, 'alumno' => $alumno, 'fecha' => $fecha]
        )->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream($archivo);
      } else {
        \Excel::create($archivo, function($excel) use ($cuenta, $alumno, $fecha) {
          $excel->sheet('Hoja 1', function($sheet) use ($cuenta, $alumno, $fecha) {
            $sheet->loadView('admin.reportes.cuenta_alumno_rept', array(
              'cuenta' => $cuenta,
              'alumno' => $alumno,
              'fecha' => $fecha,
            ));
          });
        })->download('xls');
      }
    }}
