<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Categoria;
use JSoria\InstitucionDetalle;
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
        //return $id_institucion.' '.$id_detalle_institucion.' '.$id_grado;
        $datas = Categoria::join('deuda_ingreso','categoria.id','=','deuda_ingreso.id_categoria')
                            ->join('alumno','deuda_ingreso.id_alumno','=','alumno.nro_documento')
                            ->where('deuda_ingreso.estado_pago','=',0)
                            ->where('alumno.id_grado','=',$id_grado)
                            ->where('id_detalle_institucion','=',$id_detalle_institucion)
                            //->whereBetween('fecha_hora_ingreso',[$fecha_inicio,$fecha_fin])
                            /*->where(function($query2) use($fecha_inicio,$fecha_fin){
                                $query2->where('fecha_hora_ingreso','>',$fecha_inicio)
                                      ->orwhere('fecha_hora_ingreso','<',$fecha_fin);
                            })*/
                            ->select('alumno.nombres','alumno.apellidos','nombre','deuda_ingreso.saldo','deuda_ingreso.descuento')
                            ->orderBy('alumno.nro_documento')
                            ->get();

        $nombre_nivel= InstitucionDetalle::where('id','=',$id_detalle_institucion)
                            ->select('nombre_division')
                            ->first();        

        //return $datas;

/*select concat(A.nombres, ' ' ,A.apellidos) as Alumno, C.nombre, D.saldo - D.descuento as monto 
from jsoria_categoria AS C inner join jsoria_deuda_ingreso AS D
on D.id_categoria = C.id inner join jsoria_alumno AS A on D.id_alumno = A.nro_documento
where D.estado_pago = '0'
    and A.id_grado = id_grado
    and C.id_detalle_institucion = id_detalle_institucion
order by A.nro_documento*/

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


        $view =  \View::make('pdf.AdminAlumnosDeudores', compact('id_institucion','id_detalle_institucion','id_grado','datas','fecha_inicio','fecha_fin','nombre_nivel'))->render();

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
