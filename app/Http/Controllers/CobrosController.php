<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Alumno;
use JSoria\Categoria;
use JSoria\Deuda_Ingreso;
use JSoria\Institucion;
use JSoria\InstitucionDetalle;
use JSoria\Http\Controllers\HerramientasController;

use Auth;
//use Escpos;
//use WindowsPrintConnector;

class CobrosController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('Cajera');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cajera.cobros.index');
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

    /**
    * Buscar Deudas de Alumno o Pago único
    **/
    public function buscarDeudas(Request $request, $nro_documento)
    {
        if ($request->ajax()) {
            $alumno = Alumno::find($nro_documento);

            if ($alumno) {
                $alumno = Alumno::join('grado','alumno.id_grado','=','grado.id')
                          ->where('alumno.nro_documento','=', $nro_documento)
                          ->select('alumno.nro_documento', 'alumno.nombres', 'alumno.apellidos', 'grado.id_detalle')
                          ->first();
                $id_institucion = InstitucionDetalle::find($alumno->id_detalle)->id_institucion;
                $institucion =  Institucion::find($id_institucion);
                $detalle_institucion = InstitucionDetalle::where('id_institucion', '=', $id_institucion)
                                       ->where('nombre_division', '=', 'Todo')
                                       ->first()->id;
                $categorias = Categoria::where('tipo', '=', 'sin_factor')
                                       ->where('estado', '=', 1)
                                       ->where('id_detalle_institucion','=', $detalle_institucion)
                                       ->get();

                $deudas = Deuda_Ingreso::join('categoria','deuda_ingreso.id_categoria','=','categoria.id')
                          ->where('deuda_ingreso.id_alumno','=', $nro_documento)
                          ->where('deuda_ingreso.estado_pago','=', 0)
                          ->select('deuda_ingreso.id','categoria.nombre','deuda_ingreso.saldo', 'deuda_ingreso.descuento', 'categoria.tipo', 'categoria.fecha_fin', 'deuda_ingreso.estado_descuento', 'deuda_ingreso.estado_fraccionam', 'categoria.destino')
                          ->get();

                $hoy = date('Y/m/d');
                foreach ($deudas as $deuda) {
                    if ($deuda->tipo == "pension" && $deuda->estado_descuento == "0" && $deuda->estado_fraccionam == "0") {
                        $descuento = 0;
                        $tiempo = strtotime($deuda->fecha_fin);
                        $fecha_fin = date('Y/m/d', $tiempo);
                        $descuento = $id_institucion == "3" && $hoy <= $fecha_fin ? floatval($deuda->saldo) * 0.11 : $descuento;
                        $descuento = $id_institucion == "4" && $hoy <= $fecha_fin ? floatval($deuda->saldo) * 0.15 : $descuento;
                        $deuda->descuento = $descuento;
                        $deuda->save();
                    }
                }

                $response = array($alumno, $institucion, $deudas, $categorias);

                return $response;
            } else {
                $deuda = Deuda_Ingreso::find($nro_documento);

                if ($deuda->cliente_extr != null && $deuda->descripcion_extr != null) {
                    return response()->json(['res' => 'hay deuda', 'deuda' => $deuda]);
                } else {
                    return response()->json(['mensaje' => 'No se encuentra alumno ni codigo correspondiente al dato ingresado.']);
                }
            }
        } else {
            return response()->json(['mensaje' => 'Esta petición sólo se puede acceder desde AJAX.']);
        }
    }

    public function guardarCobro(Request $request)
    {
        $mensaje = '';

        if ($request->ajax()) {
            $deudas = $request['id_pagos'];
            $deudas = array_filter(explode(',', $deudas));

            $pagos = array();
            $monto_total = 0;

            foreach ($deudas as $deuda) {
                $pago = Deuda_Ingreso::find($deuda);
                $pago->estado_pago = 1;
                $pago->fecha_hora_ingreso = date("Y-m-d H:i:s");
                $pago->id_cajera = Auth::user()->id;
                $pago->save();

                $categoria = Categoria::find($pago->id_categoria);
                $monto = floatval($pago->saldo) - floatval($pago->descuento);
                $monto_total += $monto;
                $concepto = array($categoria->nombre, $monto);
                array_push($pagos, $concepto);
            }

            $compras = $request['id_compras'];
            $compras = array_filter(explode(',', $compras));
            $nro_compras = intval(count($compras) / 2);

            $nro_documento = $request['nro_documento'];
            for ($i = 0; $i < $nro_compras; $i++) {
                $i1 = $i + 1;
                Deuda_Ingreso::create([
                    'saldo' => $compras[$i1],
                    'estado_pago' => 1,
                    'id_categoria' => $compras[$i],
                    'id_alumno' => $nro_documento
                ]);

                $categoria = Categoria::find($compras[$i]);
                $monto = $compras[$i1];
                $monto_total += $monto;
                $concepto = array($categoria->nombre, $monto);
                array_push($pagos, $concepto);
            }

            $alumno = Alumno::find($nro_documento);
            $nombre_completo = strtoupper($alumno->nombres . " " . $alumno->apellidos);

            HerramientasController::imprimir($nro_documento, $nombre_completo, $pagos, $monto_total);

            $mensaje = 'Pagos de alumno correctamente actualizados.';
            return response()->json(['mensaje' => $mensaje]);
        }
    }

}
