<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Egreso;
use DB;

class AdminReporteListarEgresos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reportes.ListarEgresos');
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
        //$id_institucion = $request->id_institucion;

        $id_rubro = $request['rubro'];        

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        //return $id_institucion .' '.$id_rubro;

        if (isset($_POST['checkbox_todos']))
        {
//TODOS CHECKED
        $datas = Egreso::join('detalle_egreso','id','=','detalle_egreso.id_egreso')
                            ->join('rubro','detalle_egreso.id_rubro','=','rubro.id')
                            ->where('id_institucion','=',$id_institucion)
                            ->whereBetween('fecha',[$fecha_inicio,$fecha_fin])
                            ->select('tipo_comprobante','numero_comprobante','nombre','monto')
                            ->get();
        }
        else
        {
//TODOS NO CHECKED            
        $datas = Egreso::join('detalle_egreso','id','=','detalle_egreso.id_egreso')
                            ->join('rubro','detalle_egreso.id_rubro','=','rubro.id')
                            ->where('id_institucion','=',$id_institucion)
                            ->where('detalle_egreso.id_rubro','=',$id_rubro)
                            ->whereBetween('fecha',[$fecha_inicio,$fecha_fin])
                            ->select('tipo_comprobante','numero_comprobante','nombre','monto')
                            ->get();
        }
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
        $view =  \View::make('pdf.AdminListarEgresos', compact('id_institucion','id_rubro','datas','fecha_inicio','fecha_fin'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('AdminListarEgresos');
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
