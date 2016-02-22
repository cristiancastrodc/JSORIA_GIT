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

use Escpos;
use WindowsPrintConnector;

class CobrosController extends Controller
{
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

                if ($deuda) {
                    return response()->json(['res' => 'hay deuda']);
                } else {
                    return response()->json(['mensaje' => 'No se encuentra alumno ni codigo correspondiente al dato ingresado.']);
                }
            }
        } else {
            return response()->json(['mensaje' => 'Esta petición sólo se puede acceder desde AJAX.']);
        }
    }

    public function imprimir()
    {
        try {
            // Enter the share name for your USB printer here
            //$connector = "Ticketera";
            $connector = new WindowsPrintConnector("Tickets");

            /* Print a "Hello world" receipt" */
            $printer = new Escpos($connector);
            $printer -> text("Corporacion JSoria!\n");
            $printer -> cut();

            /* Close printer */
            $printer -> close();
        } catch(Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
    }

    public function guardarCobro(Request $request)
    {
        if ($request->ajax()) {
            $deudas = $request['id_pagos'];
            $deudas = explode(',', $deudas);

            $conta = "";
            foreach ($deudas as $deuda) {
                $pago = Deuda_Ingreso::find($deuda);
                $pago->estado_pago = 1;
                $pago->save();
            }
            return $conta;
        }
    }
}
