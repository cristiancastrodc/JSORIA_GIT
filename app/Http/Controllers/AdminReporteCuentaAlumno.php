<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Deuda_Ingreso;
use JSoria\InstitucionDetalle;
use JSoria\Institucion;

class AdminReporteCuentaAlumno extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reportes.CuentaAlumno');
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
        $id_alumno = $request['nro_documento'];

        $datas = Deuda_Ingreso::join('categoria','id_categoria','=','categoria.id')
                            ->join('alumno','id_alumno','=','alumno.nro_documento')
                            ->where('estado_pago','=',0)
                            ->where('id_alumno','=',$id_alumno)
                            ->select('categoria.nombre','saldo','descuento','alumno.nombres','alumno.apellidos','categoria.id_detalle_institucion')
                            ->get();

        $id_detalle_institucion = $datas[0]->id_detalle_institucion;
       
        $Institucion_alumno = InstitucionDetalle::join('institucion','id_institucion','=','institucion.id')
                                                ->where('detalle_institucion.id','=',$id_detalle_institucion)
                                                ->select('detalle_institucion.nombre_division','Institucion.nombre')
                                                ->get();

        $view =  \View::make('pdf.AdminCuentaAlumno', compact('id_alumno','datas','Institucion_alumno'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('AdminCuentaAlumno'); 
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
