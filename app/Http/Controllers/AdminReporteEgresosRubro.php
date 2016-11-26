<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Egreso;
use DB;
use JSoria\Usuario_Modulos;

class AdminReporteEgresosRubro extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modulos = Usuario_Modulos::modulosDeUsuario();
        return view('admin.reportes.EgresosRubro', ['modulos' => $modulos]);
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
    public function procesarReporte(Request $request)
    {
        $id_institucion = $request['id_institucion'];
        $tipo_reporte = $request->tipo_reporte;
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];

        $datas = Egreso::join('detalle_egreso','id','=','detalle_egreso.id_egreso')
                            ->join('rubro','detalle_egreso.id_rubro','=','rubro.id')
                            ->where('id_institucion','=',$id_institucion)
                            ->whereBetween('fecha_registro',[$fecha_inicio,$fecha_fin])
                            ->groupBy('nombre','id_rubro')
                            ->select('nombre',DB::raw('Sum(monto) as montos'))
                            ->get();

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
            $view =  \View::make('pdf.AdminEgresosRubro', compact('id_institucion','datas','fecha_inicio','fecha_fin'))->render();
            $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('AdminEgresosRubro'); 
        } else {
            \Excel::create('AdminEgresosRubro', function($excel) use ($id_institucion, $datas, $fecha_inicio, $fecha_fin) {
              $excel->sheet('Hoja 1', function($sheet) use ($id_institucion, $datas, $fecha_inicio, $fecha_fin) {
                $sheet->loadView('pdf.AdminEgresosRubro', array(
                  'id_institucion' => $id_institucion,
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
