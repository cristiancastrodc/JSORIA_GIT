<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\ActividadesCreateRequest;
use JSoria\Http\Requests\ActividadesUpdateRequest;
use JSoria\Http\Controllers\Controller;

use JSoria\Categoria;
use JSoria\InstitucionDetalle;
use JSoria\Deuda_Ingreso;
use JSoria\Alumno;
use JSoria\Usuario_Modulos;

class ActividadesController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modulos = Usuario_Modulos::modulosDeUsuario();
        return view('admin.actividad.index', ['modulos' => $modulos]);
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
    public function store(ActividadesCreateRequest $request)
    {
        if ($request->ajax()) {
            $nombre = $request['nombre'];
            $monto = $request['monto'];
            $id_detalle_institucion = $request['id_detalle_institucion'];

            $institucion_detalle = InstitucionDetalle::find($id_detalle_institucion);
            $nombre_division = $institucion_detalle->nombre_division;

            if ($nombre_division == 'Todo') {

                $id_institucion = $institucion_detalle->id_institucion;
                $detalles_institucion = InstitucionDetalle::where('id_institucion', '=', $id_institucion)
                                        ->where('nombre_division', '<>', 'Todo')
                                        ->get();
                $resp = array();
                foreach ($detalles_institucion as $detalle) {
                    $id_categoria = Categoria::create([
                        'nombre' => $nombre,
                        'monto' => $monto,
                        'tipo' => 'actividad',
                        'estado' => 1,
                        'id_detalle_institucion' => $detalle->id
                    ])->id;

                    $alumnos = Alumno::alumnos_detalle_institucion($detalle->id);

                    foreach ($alumnos as $alumno) {
                        Deuda_Ingreso::create([
                            'saldo' => $monto,
                            'id_categoria' => $id_categoria,
                            'id_alumno' => $alumno->nro_documento
                        ]);
                    }
                }

                return response()->json(['mensaje' => 'everything iS OK']);
            } else {
                $id_categoria = Categoria::create([
                    'nombre' => $nombre,
                    'monto' => $monto,
                    'tipo' => 'actividad',
                    'estado' => 1,
                    'id_detalle_institucion' => $id_detalle_institucion
                ])->id;

                $alumnos = Alumno::alumnos_detalle_institucion($id_detalle_institucion);

                foreach ($alumnos as $alumno) {
                    Deuda_Ingreso::create([
                        'saldo' => $monto,
                        'id_categoria' => $id_categoria,
                        'id_alumno' => $alumno->nro_documento
                    ]);
                }
                return response()->json(['mensaje' => 'everything iS OK']);
            }
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
    public function update(ActividadesUpdateRequest $request, $id)
    {
        $categoria = Categoria::find($id);

        $operacion = $request['operacion'];

        if ($operacion == 'actualizar') {
            $categoria->nombre = $request['nombre'];
            $categoria->monto = $request['monto'];
            $categoria->save();

            /* Actualizar deudas relacionadas */
            Deuda_Ingreso::where('id_categoria', '=', $id)->where('estado_pago', '=', 0)->update(['saldo' => $request['monto']]);
        } elseif ($operacion == 'estado') {
            $categoria->estado = $request['estado'];
            $categoria->save();
        }

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
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

    /*
    * Listar actividades
    */
    public function listaActividades(Request $request, $id_detalle_institucion) {
        if ($request->ajax()) {
            $actividades = Categoria::actividadesDetalle($id_detalle_institucion);
            return response()->json($actividades);
        }
    }
}
