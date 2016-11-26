<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Egreso;
use DB;
use JSoria\Usuario_Modulos;
use JSoria\Rubro;

class AdminReporteListarEgresos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rubros = Rubro::all();
        $modulos = Usuario_Modulos::modulosDeUsuario();
        return view('admin.reportes.ListarEgresos', ['modulos' => $modulos, 'rubros' => $rubros]);
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
    /**
     * Remove the specified resource from storage.
     */
    public function procesar(Request $request)
    {
        $tipo_reporte = $request->tipo_reporte;
        $id_institucion = $request['id_institucion'];
        //$id_institucion = $request->id_institucion;

        $id_rubro = $request['rubro'];        

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        //return $id_institucion .' '.$id_rubro;

//TODAS INSTITUCIONES NO CHECKED            
            if (isset($_POST['checkbox_todos_rubros']))
            {
    //TODOS CHECKED
            $datas = Egreso::join('detalle_egreso','id','=','detalle_egreso.id_egreso')
                                ->join('rubro','detalle_egreso.id_rubro','=','rubro.id')
                                ->where('id_institucion','=',$id_institucion)
                                ->whereBetween('fecha_registro',[$fecha_inicio,$fecha_fin])
                                ->select('tipo_comprobante','numero_comprobante','nombre','monto', 'fecha_registro')
                                ->get();
            }
            else
            {
    //TODOS NO CHECKED            
            $datas = Egreso::join('detalle_egreso','id','=','detalle_egreso.id_egreso')
                                ->join('rubro','detalle_egreso.id_rubro','=','rubro.id')
                                ->where('id_institucion','=',$id_institucion)
                                ->where('detalle_egreso.id_rubro','=',$id_rubro)
                                ->whereBetween('fecha_registro',[$fecha_inicio,$fecha_fin])
                                ->select('tipo_comprobante','numero_comprobante','nombre','monto', 'fecha_registro')
                                ->get();
            }
//        }            



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
        $fecha_archivo = date('d-m-Y H:i:s');
        $archivo = 'Reporte de Lista de Egresos' . $fecha_archivo;
        if ($tipo_reporte == 'pdf') {
            $view =  \View::make('pdf.AdminListarEgresos', compact('id_institucion','id_rubro','datas','fecha_inicio','fecha_fin'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('AdminListarEgresos');
        } else {
            \Excel::create($archivo, function($excel) use ($id_institucion, $id_rubro, $datas, $fecha_inicio, $fecha_fin) {
              $excel->sheet('Hoja 1', function($sheet) use ($id_institucion, $id_rubro, $datas, $fecha_inicio, $fecha_fin) {
                $sheet->loadView('pdf.AdminListarEgresos', array(
                  'id_institucion' => $id_institucion,
                  'id_rubro' => $id_rubro,
                  'datas' => $datas,
                  'fecha_inicio' => $fecha_inicio,
                  'fecha_fin' => $fecha_fin,
                ));
              });
            })->download('xls');
        }
        
    }
}
