<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Categoria;
use Carbon\Carbon;
use DB;
use Auth;
class CajeraReporteCobros extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today= Carbon::now();
        $today=$today->toDateString();
        $id_cajera=Auth::user()->id;

        $datas = Categoria::join('deuda_ingreso','categoria.id','=','deuda_ingreso.id_categoria')
                            ->join('alumno','deuda_ingreso.id_alumno','=','alumno.nro_documento')
                            ->where('estado_pago','=',1)
                            ->where(DB::raw('date(fecha_hora_ingreso)'),'=',$today)
                            ->where('id_cajera','=',$id_cajera)
                            ->select(DB::raw('date(fecha_hora_ingreso) as Fecha'),'alumno.nombres','alumno.apellidos','deuda_ingreso.cliente_extr','categoria.nombre','deuda_ingreso.saldo','deuda_ingreso.descuento')
                            ->get();   
        $view =  \View::make('pdf.CajeraCobros', compact('datas','today'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('CajeraCobros');                          
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
