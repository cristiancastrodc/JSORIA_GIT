<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Egreso;
use DB;

class AdminReporteEgresosTotales extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reportes.EgresosTotales');
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
    {}
    
    public function procesarReporteTotal(Request $request)
    {
        $id_institucion = $request['id_institucion'];
        //$id_institucion = $request->id_institucion;

        $tipo_reporte = $request->tipo_reporte;
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];        
        $radio_btn_fecha=$request['inlineRadioOptions'];
        //return $radio_btn_fecha;
//        $conj_fechas = array();
        switch ($radio_btn_fecha) {
            case 'dias':
                $datas = Egreso::join('detalle_egreso','id','=','detalle_egreso.id_egreso')
                                    ->where('id_institucion','=',$id_institucion)
                                    ->whereBetween('fecha_registro',[$fecha_inicio,$fecha_fin])
                                    ->groupBy(DB::raw('date(fecha)'))
                                    ->get([DB::raw('date(fecha) as fecha1'),DB::raw('Sum(monto) as montos')]);
                break;
            case 'mes':
                $datas = Egreso::join('detalle_egreso','id','=','detalle_egreso.id_egreso')
                                    ->where('id_institucion','=',$id_institucion)
                                    ->whereBetween('fecha_registro',[$fecha_inicio,$fecha_fin])
                                    ->groupBy(DB::raw('month(fecha)'),DB::raw('year(fecha)'))
                                    ->get([DB::raw('month(fecha) as fecha1'),DB::raw('year(fecha) as fecha2'),DB::raw('Sum(monto) as montos')]);
                break;
            case 'anio':
                $datas = Egreso::join('detalle_egreso','id','=','detalle_egreso.id_egreso')
                                    ->where('id_institucion','=',$id_institucion)
                                    ->whereBetween('fecha_registro',[$fecha_inicio,$fecha_fin])
                                    ->groupBy(DB::raw('year(fecha)'))
                                    ->get([DB::raw('year(fecha) as fecha1'),DB::raw('Sum(monto) as montos')]);
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

        // Generar el PDF
        if ($tipo_reporte == 'pdf') {            
            $view =  \View::make('pdf.AdminEgresosTotales', compact('id_institucion','datas','fecha_inicio','fecha_fin','radio_btn_fecha'))->render();
            $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('AdminEgresosTotales'); 
        } else {
            \Excel::create('AdminEgresosTotales', function($excel) use ($id_institucion, $datas, $fecha_inicio, $fecha_fin, $radio_btn_fecha) {
              $excel->sheet('Hoja 1', function($sheet) use ($id_institucion, $datas, $fecha_inicio, $fecha_fin, $radio_btn_fecha) {
                $sheet->loadView('pdf.AdminEgresosTotales', array(
                  'id_institucion' => $id_institucion,
                  'datas' => $datas,
                  'fecha_inicio' => $fecha_inicio,
                  'fecha_fin' => $fecha_fin,
                  'radio_btn_fecha' => $radio_btn_fecha,

                ));
              });
            })->download('xls');
        }          
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
