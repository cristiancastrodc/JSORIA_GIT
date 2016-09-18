<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\EgresoCreateRequest;
use JSoria\Http\Requests\EgresoUpdateRequest;
use JSoria\Http\Controllers\Controller;

use JSoria\Balance;
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
        $id_usuario = Auth::user()->id;

        $permisos = Permiso::join('institucion', 'permisos.id_institucion', '=', 'institucion.id')
                           ->where('permisos.id_usuario', '=', $id_usuario)
                           ->select('institucion.id', 'institucion.nombre')->get();

        $rubros = Rubro::All();

        $egreso = Egreso::find($id);

        $comprobante = '';
        if ($egreso->tipo_comprobante == '1') {
            $comprobante = 'Boleta';
        } else if ($egreso->tipo_comprobante == '2') {
            $comprobante = 'Factura';
        } else if ($egreso->tipo_comprobante == '3') {
            $comprobante = 'Comprobante de Pago';
        } else if ($egreso->tipo_comprobante == '4') {
            $comprobante = 'Comprobante de Egreso';
        } else if ($egreso->tipo_comprobante == '5') {
            $comprobante = 'Recibo por Honorarios';
        }

        $detalles_egreso = DetalleEgreso::join('rubro', 'detalle_egreso.id_rubro', '=', 'rubro.id')
                           ->select('detalle_egreso.*', 'rubro.nombre')
                           ->where('id_egreso', $id)
                           ->get();

        return view('tesorera.egreso.edit', compact('permisos', 'rubros', 'egreso', 'comprobante', 'detalles_egreso'));
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DetalleEgreso::where('id_egreso', $id)
                         ->delete();

            Egreso::where('id', $id)
                  ->delete();

            return response()->json(['mensaje' => 'OK', 'tipo' => 'exito']);
        }
    }

    /*** Crear un Egreso ***/
    public function crearEgreso(EgresoCreateRequest $request)
    {
        if ($request->ajax()) {
            $id_institucion = $request->id_institucion;
            $tipo_comprobante = $request->tipo_comprobante;
            $numero_comprobante = 0;
            $fecha_egreso = $request->fecha_egreso;
            $razon_social = $request->razon_social;
            $responsable = $request->responsable;
            /*if ($tipo_comprobante == "3") {
                $egreso = Egreso::where("tipo_comprobante", 3)
                          ->select("numero_comprobante")
                          ->orderBy('numero_comprobante', 'desc')
                          ->first();
                if ($egreso) {
                    $numero_comprobante += intval($egreso->numero_comprobante) + 1;
                } else {
                    $numero_comprobante = 1;
                }
            } else {*/
                $numero_comprobante = $request->numero_comprobante;
            //}

            $fecha_registro = date('Y-m-d H:i:s');
            $id_egreso = Egreso::create([
                "tipo_comprobante" => $tipo_comprobante,
                "numero_comprobante" => $numero_comprobante,
                "fecha" => $fecha_egreso,
                "id_institucion" => $id_institucion,
                "id_tesorera" => Auth::user()->id,
                "fecha_registro" => $fecha_registro,
                "razon_social" => $razon_social,
                "responsable" => $responsable,
            ])->id;

            $detalle_egreso = $request->detalle_egreso;

            $monto_total = 0;
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
                $monto_total += $detalle['monto'];
            }
            $response = array('mensaje' => 'Egreso creado exitosamente.');
            /*if ($tipo_comprobante == "3") {
                $response["nro_resultado"] = $numero_comprobante;
            } else {*/
                $response["nro_resultado"] = "";
            //}

            /** Registrar el egreso en la tabla de Balance **/
            $registro = Balance::where('fecha', date('Y-m-d'))
                               ->where('id_tesorera', Auth::user()->id)
                               ->first();
            if ($registro) {
                $registro->egresos += $monto_total;
                $registro->save();
            }
            else {
                $Saldo = 0;
                $registro_anterior = Balance::where('id_tesorera', Auth::user()->id)
                                            ->orderBy('fecha', 'desc')
                                            ->first();
                if ($registro_anterior) {
                    $Saldo = $registro_anterior['ingresos'] - $registro_anterior['egresos'];
                }
                Balance::create([
                    'fecha' => date('Y-m-d'),
                    'id_tesorera' => Auth::user()->id,
                    'ingresos' => $Saldo,
                    'egresos' => $monto_total
                ]);
            }

            return response()->json($response);
        }
    }

    /*** Listar egresos filtrando por fecha ***/
    public function listarEgresosPorFecha(Request $request)
    {
            $egresos = Egreso::egresosPorFecha($request->fecha_egreso);
            return response()->json($egresos);
    }

    /*** Actualizar un Egreso ***/
    public function actualizar(Request $request, $id_egreso)
    {
        if ($request->ajax()) {
            $id_egreso = $request->id_egreso;
            $id_institucion = $request->id_institucion;
            $tipo_comprobante = $request->tipo_comprobante;
            $numero_comprobante = $request->numero_comprobante;
            $fecha_egreso = $request->fecha_egreso;
            $razon_social = $request->razon_social;
            $responsable = $request->responsable;

            $egreso = Egreso::find($id_egreso);
            $egreso->id_institucion = $id_institucion;
            //if ($tipo_comprobante != '3') {
                $egreso->numero_comprobante = $numero_comprobante;
            //}
            $egreso->fecha = $fecha_egreso;
            $egreso->save();

            $detalle_egreso = $request->detalle_egreso;

            foreach ($detalle_egreso as $detalle) {
                DetalleEgreso::where('id_egreso', $id_egreso)
                ->where('nro_detalle_egreso', $detalle['nro_detalle_egreso'])
                ->update([
                    'id_rubro' => $detalle['id_rubro'],
                    'descripcion' => $detalle['descripcion'],
                    'monto' => $detalle['monto']
                ]);
            }

            return response()->json(['mensaje' => 'Egreso actualizado exitosamente.']);
        }
    }

    public function egresoRubroCrear(Request $request){
        $nombre = $request['nombre'];
        Rubro::create([
            'nombre' => $nombre
        ]);
        return response()->json(['mensaje' => 'Rubro creado']);
    }
}
