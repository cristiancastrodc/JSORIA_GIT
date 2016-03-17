<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Deuda_Ingreso;
use DB;
use Carbon\Carbon;

class AdminReporteIngresosTotales extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reportes.IngresosTotales');
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


        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];        
        $radio_btn_fecha=$request['inlineRadioOptions'];
        //return $radio_btn_fecha;
//        $conj_fechas = array();
        switch ($radio_btn_fecha) {
            case 'dias':
                $datas = Deuda_Ingreso::join('categoria','id_categoria','=','categoria.id')
                                    ->join('detalle_institucion','categoria.id_detalle_institucion','=','detalle_institucion.id')
                                    ->where('estado_pago','=',1)
                                    ->where('detalle_institucion.id_institucion','=',$id_institucion)
                                    ->whereBetween('fecha_hora_ingreso',[$fecha_inicio,$fecha_fin])
        /*                            ->where(function($query3) use($fecha_inicio,$fecha_fin){
                                        $query3->where('fecha_hora_ingreso','>',$fecha_inicio)
                                              ->orwhere('fecha_hora_ingreso','<',$fecha_fin);
                                    })*/
                                    ->groupBy(DB::raw('date(fecha_hora_ingreso)'))
                                    ->get([DB::raw('date(fecha_hora_ingreso) as fecha1'),DB::raw('Sum(saldo - descuento) as monto')]);
                break;
            case 'mes':
                $datas = Deuda_Ingreso::join('categoria','id_categoria','=','categoria.id')
                                    ->join('detalle_institucion','categoria.id_detalle_institucion','=','detalle_institucion.id')
                                    ->where('estado_pago','=',1)
                                    ->where('detalle_institucion.id_institucion','=',$id_institucion)
                                    ->whereBetween('fecha_hora_ingreso',[$fecha_inicio,$fecha_fin])
        /*                            ->where(function($query3) use($fecha_inicio,$fecha_fin){
                                        $query3->where('fecha_hora_ingreso','>',$fecha_inicio)
                                              ->orwhere('fecha_hora_ingreso','<',$fecha_fin);
                                    })*/
                                    ->groupBy(DB::raw('month(fecha_hora_ingreso)'),DB::raw('year(fecha_hora_ingreso)'))
                                    ->get([DB::raw('month(fecha_hora_ingreso) as fecha1'),DB::raw('year(fecha_hora_ingreso) as fecha2'),DB::raw('Sum(saldo - descuento) as monto')]);
                break;
            case 'anio':
                $datas = Deuda_Ingreso::join('categoria','id_categoria','=','categoria.id')
                                    ->join('detalle_institucion','categoria.id_detalle_institucion','=','detalle_institucion.id')
                                    ->where('estado_pago','=',1)
                                    ->where('detalle_institucion.id_institucion','=',$id_institucion)
                                    ->whereBetween('fecha_hora_ingreso',[$fecha_inicio,$fecha_fin])
        /*                            ->where(function($query3) use($fecha_inicio,$fecha_fin){
                                        $query3->where('fecha_hora_ingreso','>',$fecha_inicio)
                                              ->orwhere('fecha_hora_ingreso','<',$fecha_fin);
                                    })*/
                                    ->groupBy(DB::raw('year(fecha_hora_ingreso)'))
                                    ->get([DB::raw('year(fecha_hora_ingreso) as fecha1'),DB::raw('Sum(saldo - descuento) as monto')]);
                break;                

            default:
                break;
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
        switch ($radio_btn_fecha) {
            case 'dias':
                $radio_btn_fecha='DIAS';
                break;
            case 'mes':
                $radio_btn_fecha='MESES';
                break;
            case 'anio':
                $radio_btn_fecha='AÑOS';
                break;
            default:
                break;
        }        

        $view =  \View::make('pdf.AdminIngresosTotales', compact('id_institucion','datas','fecha_inicio','fecha_fin','radio_btn_fecha'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('AdminIngresosTotales'); 
        
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
