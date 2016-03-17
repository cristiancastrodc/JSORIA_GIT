<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Egreso;

class AdminReporteEgresosRubro extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reportes.EgresosRubro');
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

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];

        $datas = Egreso::join('detalle_egreso','id','=','detalle_egreso.id_egreso')
                            ->join('rubro','detalle_egreso.id_rubro','=','rubro.id')
                            ->where('id_institucion','=',$id_institucion)
                            ->whereBetween('fecha',[$fecha_inicio,$fecha_fin])
                            /*->where(function($query2) use($fecha_inicio,$fecha_fin){
                                $query2->where('fecha_hora_ingreso','>',$fecha_inicio)
                                      ->orwhere('fecha_hora_ingreso','<',$fecha_fin);
                            })*/
                            ->groupBy('nombre','id_rubro')
//                            ->select('tipo_comprobante','numero_comprobante','nombre','monto')
                            ->get();


/*select jsoria_rubro.nombre as Rubro,sum(jsoria_detalle_egreso.monto) as Monto
from jsoria_egreso
inner join jsoria_detalle_egreso
on jsoria_egreso.id = jsoria_detalle_egreso.id_egreso
inner join jsoria_rubro
on jsoria_detalle_egreso.id_rubro = jsoria_rubro.id
where jsoria_egreso.id_institucion = id_institucion   and (jsoria_egreso.fecha between ''fecha_inicio' and  ''fecha_fin')
group by jsoria_rubro.nombre, jsoria_detalle_egreso.id_rubro;*/
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
        $view =  \View::make('pdf.AdminEgresosRubro', compact('id_institucion','data','date', 'invoice'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('AdminEgresosRubro'); 
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
