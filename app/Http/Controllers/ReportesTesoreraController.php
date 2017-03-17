<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Balance;
use JSoria\Deuda_Ingreso;
use JSoria\Egreso;
use Auth;

class ReportesTesoreraController extends Controller
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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*** Reporte de Balance de Ingresos / Egresos ***/
    public function mostrarBalanceIngresosEgresos()
    {
        return view('tesorera.reportes.balance');
    }
    /*** Reporte de Balance de Ingresos / Egresos ***/
    public function balanceIngresosEgresos(Request $request)
    {
        $tipo_reporte = $request->tipo_reporte;
        $fecha = date('d-m-Y H:i:s');
        $archivo = 'Balance Ingresos Egresos-' . date('dmYHis');
        $balance = Balance::getBalanceTesorera(Auth::user()->id, date('Y-m-d'));
        # $cobros = Deuda_Ingreso::where();
        $balance_detallado = Balance::getBalanceDetalladoTesorera(Auth::user()->id, date('Y-m-d'));

        if ($tipo_reporte == 'pdf') {
            $view = \View::make('tesorera.reportes.balance_rept', compact('fecha', 'balance', 'balance_detallado'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream($archivo);
        } else {
            \Excel::create($archivo, function($excel) use ($fecha, $balance, $balance_detallado) {
              $excel->sheet('Hoja 1', function($sheet) use ($fecha, $balance, $balance_detallado) {
                $sheet->loadView('tesorera.reportes.balance_rept', array(
                  'fecha' => $fecha,
                  'balance' => $balance,
                  'balance_detallado' => $balance_detallado,
                ));
              });
            })->download('xls');
        }
    }
}
