<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\BalanceGenerarRequest;
use JSoria\Http\Controllers\Controller;

use JSoria\Balance;
use JSoria\User;

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
        return view('admin.reportes.balance', compact('tesoreras'));
    }

    /*** Reporte de Balance de Ingresos / Egresos: Procesar ***/
    public function balanceIngresosEgresosProcesar(BalanceGenerarRequest $request)
    {
        $fecha = date('d-m-Y H:i:s');
        $archivo = 'Balance Ingresos Egresos-' . date('dmYHis');

        $balance = Balance::getBalanceTesorera($request->id_tesorera, date('Y-m-d'));
        $balance_detallado = Balance::getBalanceDetalladoTesorera($request->id_tesorera, date('Y-m-d'));

        $tesorera = User::find($request->id_tesorera);
        $nombre_tesorera = $tesorera->nombres . ' ' . $tesorera->apellidos;

        $view = \View::make('admin.reportes.balance_rept', compact('fecha', 'balance', 'balance_detallado', 'nombre_tesorera'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream($archivo);
    }

}
