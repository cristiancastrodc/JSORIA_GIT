<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\EgresoCreateRequest;
use JSoria\Http\Requests\EgresoUpdateRequest;
use JSoria\Http\Controllers\Controller;

use JSoria\DetalleEgreso;
use JSoria\Egreso;
use JSoria\Permiso;
use JSoria\Rubro;
use Auth;

class EgresosController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('tesorera');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $egresos = Egreso::All();
        return view('tesorera.egreso.index', compact('egresos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_usuario = Auth::user()->id;

        $permisos = Permiso::join('institucion', 'permisos.id_institucion', '=', 'institucion.id')
                           ->where('permisos.id_usuario', '=', $id_usuario)
                           ->select('institucion.id', 'institucion.nombre')->get();

        $rubros = Rubro::All();

        return view('tesorera.egreso.create', compact('permisos', 'rubros'));
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

    /*** Crear el egreso maestro ***/
    public function crearEgreso(EgresoCreateRequest $request)
    {
        if ($request->ajax()) {
            $id_institucion = $request->id_institucion;
            $tipo_comprobante = $request->tipo_comprobante;
            $numero_comprobante = 0;
            $fecha_egreso = $request->fecha_egreso;
            if ($tipo_comprobante == "3") {
                $egreso = Egreso::where("tipo_comprobante", 3)
                          ->select("numero_comprobante")
                          ->orderBy('numero_comprobante', 'desc')
                          ->first();
                if ($egreso) {
                    $numero_comprobante += intval($egreso->numero_comprobante) + 1;
                } else {
                    $numero_comprobante = 1;
                }
            } else {
                $numero_comprobante = $request->numero_comprobante;
            }

            $id_egreso = Egreso::create([
                "tipo_comprobante" => $tipo_comprobante,
                "numero_comprobante" => $numero_comprobante,
                "fecha" => $fecha_egreso,
                "id_institucion" => $id_institucion,
                "id_tesorera" => Auth::user()->id,
            ])->id;

            $detalle_egreso = $request->detalle_egreso;

            $nro_detalle = 1;
            foreach ($detalle_egreso as $detalle) {
                DetalleEgreso::create([
                    'id_egreso' => $id_egreso,
                    'nro_detalle_egreso' => $nro_detalle,
                    'id_rubro' => $detalle['id_rubro'],
                    'monto' => $detalle['monto'],
                    'descripcion' => $detalle['descripcion'],
                ]);
                $nro_detalle++;
            }

            return response()->json(['mensaje' => 'Egreso creado exitosamente.']);
        }
    }
}
