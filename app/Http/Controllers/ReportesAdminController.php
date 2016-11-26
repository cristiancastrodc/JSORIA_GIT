<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;
use JSoria\Http\Requests;
use JSoria\Http\Requests\BalanceGenerarRequest;
use JSoria\Http\Controllers\Controller;
use JSoria\Balance;
use JSoria\Deuda_Ingreso;
use JSoria\User;
use JSoria\Usuario_Modulos;
use NumeroALetras;

class ReportesAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('admin.reportes.balance');
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

    /*** Reporte de Balance de Ingresos / Egresos: Mostrar formulario ***/
    public function balanceIngresosEgresos()
    {
        $tesoreras = User::getTesoreras();
        $modulos = Usuario_Modulos::modulosDeUsuario();
        return view('admin.reportes.balance', compact('tesoreras', 'modulos'));
    }

    /*** Reporte de Balance de Ingresos / Egresos: Procesar ***/
    public function balanceIngresosEgresosProcesar(BalanceGenerarRequest $request)
    {
      // Definir el nombre del archivo
      $archivo = 'Balance Ingresos Egresos-' . date('dmYHis');
      // Recuperar valores enviados y de la base de datos
      $tipo_reporte = $request->tipo_reporte;
      $tesorera = User::find($request->id_tesorera);
      $nombre_tesorera = $tesorera->nombres . ' ' . $tesorera->apellidos;
      $balance = Balance::getBalanceTesorera($request->id_tesorera, date('Y-m-d'));
      $balance_detallado = Balance::getBalanceDetalladoTesorera($request->id_tesorera, date('Y-m-d'));
      // Recuperar fecha para el reporte
      $fecha = date('d-m-Y H:i:s');
      // Generar el PDF
      if ($tipo_reporte == 'pdf') {
        $view = \View::make('admin.reportes.balance_rept', compact('fecha', 'balance', 'balance_detallado', 'nombre_tesorera'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream($archivo);
      } else {
        \Excel::create($archivo, function($excel) use ($nombre_tesorera, $balance, $balance_detallado) {
            $excel->sheet('Hoja 1', function($sheet) use ($nombre_tesorera, $balance, $balance_detallado) {
                $fecha = date('d-m-Y H:i:s');
                $sheet->loadView('admin.reportes.balance_rept', array(
                  'fecha' => $fecha,
                  'nombre_tesorera' => $nombre_tesorera,
                  'balance' => $balance,
                  'balance_detallado' => $balance_detallado,
                ));
            });
        })->download('xls');
      }
    }
    /**
     * Mostrar la pantalla de Lista de Ingresos por Cajera
     */
    public function ingresosPorCajera()
    {
      $cajeras = User::getCajeras();
      $modulos = Usuario_Modulos::modulosDeUsuario();
      return view('admin.reportes.ingresos_cajera',
        ['cajeras' => $cajeras, 'modulos' => $modulos]
      );
    }
    /**
     * Mostrar la pantalla de Lista de Ingresos por Cajera
     */
    public function procesarIngresosPorCajera(Request $request)
    {
      // Recuperar valores enviados y de la base de datos
      $cajera = User::find($request->id_cajera);
      $nombre_cajera = $cajera->nombres . ' ' . $cajera->apellidos;
      // Definir el nombre del archivo
      $fecha_archivo = date('d-m-Y H:i:s');
      $archivo = 'Lista de Ingresos por Cajera-' . $fecha_archivo;
      $tipo_reporte = $request->tipo_reporte;
      $fecha = $request->fecha;
      $ingresos = Deuda_Ingreso::cajeraIngresosPorDia($request->id_cajera, $fecha);
      $total = 0;
      foreach ($ingresos as $ingreso) {
        $total += floatval($ingreso->monto);
      }
      $total = number_format($total, 2);
      // Generar el PDF
      if ($tipo_reporte == 'pdf') {
        $view = \View::make('admin.reportes.ingresos_cajera_rept', ['ingresos' => $ingresos, 'fecha' => $fecha, 'total' => $total, 'cajera' => $nombre_cajera])->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream($archivo);
      } else {
        \Excel::create($archivo, function($excel) use ($ingresos, $fecha, $total, $nombre_cajera) {
          $excel->sheet('Hoja 1', function($sheet) use ($ingresos, $fecha, $total, $nombre_cajera) {
            $sheet->loadView('admin.reportes.ingresos_cajera_rept', array(
              'ingresos' => $ingresos,
              'fecha' => $fecha,
              'total' => $total,
              'cajera' => $nombre_cajera,
            ));
          });
        })->download('xls');
      }
    }
}
