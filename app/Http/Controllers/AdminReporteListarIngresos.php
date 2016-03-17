<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Deuda_Ingreso;
use JSoria\InstitucionDetalle;

class AdminReporteListarIngresos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reportes.ListaIngresos');
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

        $id_detalle_institucion = $request['id_detalle_institucion'];
        $id_categoria = $request['id_categoria'];        

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        //return $id_detalle_institucion;
        $datas = Deuda_Ingreso::join('categoria','id_categoria','=','categoria.id')
                            ->join('detalle_institucion','categoria.id_detalle_institucion','=','detalle_institucion.id')
                            ->where('categoria.tipo','=',$id_categoria)
                            ->where('estado_pago','=',1)
                            ->where(function($query) use($id_detalle_institucion){
                                $query->where('categoria.id_detalle_institucion','=',$id_detalle_institucion)
                                      ->orwhere('detalle_institucion.nombre_division','=','Todo');
                            })
                            ->where('detalle_institucion.id_institucion','=',$id_institucion)
                            ->whereBetween('fecha_hora_ingreso',[$fecha_inicio,$fecha_fin])
                            /*->where(function($query2) use($fecha_inicio,$fecha_fin){
                                $query2->where('fecha_hora_ingreso','>',$fecha_inicio)
                                      ->orwhere('fecha_hora_ingreso','<',$fecha_fin);
                            })*/
                            ->select('fecha_hora_ingreso','id_alumno','cliente_extr','nombre','saldo','descuento')
                            ->get();
                            
        $nombre_nivel= InstitucionDetalle::where('id','=',$id_detalle_institucion)
                            ->select('nombre_division')
                            ->first();        
        //return $nombre_nivel;

        //return $datas;

/*select jsoria_deuda_ingreso.fecha_hora_ingreso,jsoria_deuda_ingreso.id_alumno,jsoria_deuda_ingreso.cliente_extr, jsoria_categoria.nombre, jsoria_deuda_ingreso.saldo - jsoria_deuda_ingreso.descuento as Monto
from jsoria_deuda_ingreso

inner join jsoria_categoria
on jsoria_deuda_ingreso.id_categoria = jsoria_categoria.id
inner join jsoria_detalle_institucion
on jsoria_categoria.id_detalle_institucion = jsoria_detalle_institucion.id

where jsoria_categoria.tipo = 'sin_factor'
    and jsoria_deuda_ingreso.estado_pago = 1
    and (jsoria_categoria.id_detalle_institucion = id_detalle_institucion   or (jsoria_detalle_institucion.nombre_division = 'Todo' 
    and jsoria_detalle_institucion.id_institucion = 'id_institucion'))
    and (date(jsoria_deuda_ingreso.fecha_hora_ingreso) between 'fecha_inicio' and  'fecha_fin');*/

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
        $view =  \View::make('pdf.AdminListarIngresos', compact('id_institucion','id_detalle_institucion','id_categoria','datas','nombre_nivel','fecha_inicio','fecha_fin'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('AdminListarIngresos');
        //return $datas;
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
