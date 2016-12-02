<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Categoria;
use Carbon\Carbon;
use DB;
use Auth;
use JSoria\Deuda_Ingreso;
use JSoria\Usuario_Modulos;

class CajeraReporteCobros extends Controller
{
    /**
     * Reporte de ingresos por día para un usuario cajera
     */
    public function index()
    {
        $modulos = Usuario_Modulos::modulosDeUsuario();
         return view('cajera.reportes.ingresos', ['modulos' => $modulos]);
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

    public function generar(Request $request)
    {
      $fecha_archivo = date('d-m-Y H:i:s');
      $archivo = 'Reporte de Ingresos-' . $fecha_archivo;
      $tipo_reporte = $request['tipo_reporte'];
      $fecha = $request['fecha'];
      $ingresos = Deuda_Ingreso::cajeraIngresosPorDia(Auth::user()->id, $fecha);
      $total = 0;
      foreach ($ingresos as $ingreso) {
        $total += floatval($ingreso->monto);
      }
      $total = number_format($total, 2);
      // Generar el PDF
      if ($tipo_reporte == 'pdf') {
        $view = \View::make('pdf.CajeraCobros', ['ingresos' => $ingresos, 'fecha' => $fecha, 'total' => $total])->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream($archivo);
      } else {
        \Excel::create($archivo, function($excel) use ($ingresos, $fecha, $total) {
          $excel->sheet('Hoja 1', function($sheet) use ($ingresos, $fecha, $total) {
            $sheet->loadView('pdf.CajeraCobros', array(
              'ingresos' => $ingresos,
              'fecha' => $fecha,
              'total' => $total,
            ));
          });
        })->download('xls');
      }
    }
}
