<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Deuda_Ingreso;
use JSoria\Egreso;

use Carbon\Carbon;
use DB;
use Auth;
class TesoreraReporteSaldo extends Controller
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
        $id_tesorera=Auth::user()->id;

        $datas1 = Deuda_Ingreso::join('retiro','deuda_ingreso.id_retiro','=','retiro.id')
                            ->leftJoin('categoria','deuda_ingreso.id_categoria','=','categoria.id')
                            ->join('detalle_institucion','categoria.id_detalle_institucion','=','detalle_institucion.id')
                            ->leftJoin('institucion','detalle_institucion.id_institucion','=','institucion.id')
                            ->where('estado_pago','=',1)
                            //->where(DB::raw('date(deuda_ingreso.fecha_hora_ingreso)'),'=',$today)
                            ->groupBy('institucion.id')
                            ->get(['institucion.nombre',DB::raw('Sum(saldo - descuento) as Total')]);
        $datas2 = Egreso::join('detalle_egreso','egreso.id','=','detalle_egreso.id_egreso')
                            ->join('institucion','egreso.id_institucion','=','institucion.id')
                            //->where(DB::raw('date(deuda_ingreso.fecha_hora_ingreso)'),'=',$today)
                            ->where('id_tesorera','=',$id_tesorera)
                            ->groupBy('egreso.id_institucion')

                            ->get(['institucion.nombre',DB::raw('Sum(monto) as Montos')]);
        return $datas1;

/*select  jsoria_institucion.nombre, sum(saldo - descuento) as Total
from jsoria_deuda_ingreso inner join jsoria_retiro on jsoria_deuda_ingreso.id_retiro = jsoria_retiro.id
left join jsoria_categoria on jsoria_deuda_ingreso.id_categoria = jsoria_categoria.id
inner join jsoria_detalle_institucion on jsoria_categoria.id_detalle_institucion = jsoria_detalle_institucion.id
left join jsoria_institucion on jsoria_detalle_institucion.id_institucion = jsoria_institucion.id
where estado_pago=1
    and (date(jsoria_deuda_ingreso.fecha_hora_ingreso) = curdate())
group by jsoria_institucion.id;

select jsoria_institucion.nombre, sum(jsoria_detalle_egreso.monto) as Monto
from jsoria_egreso
inner join jsoria_detalle_egreso on jsoria_egreso.id = jsoria_detalle_egreso.id_egreso
inner join jsoria_institucion on jsoria_egreso.id_institucion = jsoria_institucion.id
where jsoria_egreso.fecha = curdate()
and id_tesorera='id_tesorera'
group by jsoria_egreso.id_institucion*/
        $view =  \View::make('pdf.TesoreraSaldo', compact('datas1','datas2','today'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('TesoreraSaldo');
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
