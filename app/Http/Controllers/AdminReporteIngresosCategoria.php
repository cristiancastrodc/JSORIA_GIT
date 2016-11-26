<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Deuda_Ingreso;
use JSoria\InstitucionDetalle;
use DB;
use JSoria\Usuario_Modulos;

class AdminReporteIngresosCategoria extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modulos = Usuario_Modulos::modulosDeUsuario();
        return view('admin.reportes.IngresosCategoria', ['modulos' => $modulos]);
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

    }
    public function procesar(Request $request)
    {
        $id_institucion = $request['id_institucion'];
        //$id_institucion = $request->id_institucion;

        $id_detalle_institucion = $request['id_detalle_institucion'];
        $tipo_reporte = $request->tipo_reporte;
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];        


        $datas = Deuda_Ingreso::join('categoria','id_categoria','=','categoria.id')
                            ->join('detalle_institucion','categoria.id_detalle_institucion','=','detalle_institucion.id')
                            ->where('estado_pago','=',1)
                            ->where(function($query) use($id_detalle_institucion,$id_institucion){
                                $query->where('categoria.id_detalle_institucion','=',$id_detalle_institucion)
                                      ->orwhere(function($query2) use($id_institucion){
                                    $query2->where('detalle_institucion.nombre_division','=','Todo')
                                           ->where('detalle_institucion.id_institucion','=',$id_institucion);
                                });
                            })
                            ->whereBetween('fecha_hora_ingreso',[$fecha_inicio,$fecha_fin])
                            ->groupBy('id_categoria')
                            ->get(['categoria.nombre',DB::raw('Sum(saldo - descuento) as monto')]);
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
        // Generar el PDF
        if ($tipo_reporte == 'pdf') {            
            $view =  \View::make('pdf.AdminIngresosCategoria', compact('id_institucion','nombre_nivel','datas','fecha_inicio','fecha_fin'))->render();
            $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('AdminIngresosCategoria'); 
        } else {
            \Excel::create('AdminIngresosCategoria', function($excel) use ($id_institucion, $nombre_nivel, $datas, $fecha_inicio, $fecha_fin) {
              $excel->sheet('Hoja 1', function($sheet) use ($id_institucion, $nombre_nivel, $datas, $fecha_inicio, $fecha_fin) {
                $sheet->loadView('pdf.AdminIngresosCategoria', array(
                  'id_institucion' => $id_institucion,
                  'nombre_nivel' => $nombre_nivel,
                  'datas' => $datas,
                  'fecha_inicio' => $fecha_inicio,
                  'fecha_fin' => $fecha_fin,

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
