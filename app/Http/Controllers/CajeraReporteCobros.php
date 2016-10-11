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

class CajeraReporteCobros extends Controller
{
    /**
     * Reporte de ingresos por día para un usuario cajera
     */
    public function index()
    {
        $fecha = date('d-m-Y H:i:s');
        $archivo = 'Reporte de Ingresos-' . date('dmYHis');

        $ingresos = Deuda_Ingreso::cajeraIngresosPorDia(Auth::user()->id, date('Y-m-d'));
        $total = 0;
        foreach ($ingresos as $ingreso) {
            $total += floatval($ingreso->monto);
        }
        $view = \View::make('pdf.CajeraCobros', ['ingresos' => $ingresos, 'fecha' => $fecha, 'total' => number_format($total, 2)])->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view); //->setPaper('a4', 'landscape');
        return $pdf->stream($archivo);
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
}
