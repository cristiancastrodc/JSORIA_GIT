<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Categoria;
use JSoria\InstitucionDetalle;
use JSoria\Grado;

class AdminReporteAlumnosDeudores extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reportes.AlumnosDeudores');
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
        $id_institucion = $request['id_institucion'];

        $id_detalle_institucion = $request['id_detalle_institucion'];
        $id_grado = $request['grado'];

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        $datas = Categoria::join('deuda_ingreso','categoria.id','=','deuda_ingreso.id_categoria')
                            ->join('alumno','deuda_ingreso.id_alumno','=','alumno.nro_documento')
                            ->where('deuda_ingreso.estado_pago','=',0)
                            ->where('alumno.id_grado','=',$id_grado)
                            ->where('id_detalle_institucion','=',$id_detalle_institucion)
                            ->select('alumno.nombres','alumno.apellidos','nombre','deuda_ingreso.saldo','deuda_ingreso.descuento')
                            ->orderBy('alumno.nro_documento')
                            ->get();

        $nombre_nivel= InstitucionDetalle::where('id','=',$id_detalle_institucion)
                            ->select('nombre_division')
                            ->first();

        switch ($id_institucion) {
            case 1:
                $id_institucion='I.E. J. Soria';
                break;
            case 2:
                $id_institucion='CEBA Konrad Adenahuer';
                break;
            case 3:
                $id_institucion='I.S.T. Urusayhua';
                break;
            case 4:
                $id_institucion='ULP';
                break;
            default:
                break;
        }

        $id_grado=Grado::where('id','=',$id_grado)
                    ->first();


        $view =  \View::make('pdf.AdminAlumnosDeudores', compact('id_institucion','id_grado','datas','fecha_inicio','fecha_fin','nombre_nivel'))->render();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('AdminAlumnosDeudores');
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
