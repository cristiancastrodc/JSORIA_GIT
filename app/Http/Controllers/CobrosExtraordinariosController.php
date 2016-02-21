<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Deuda_Ingreso;
use JSoria\Categoria;
use JSoria\InstitucionDetalle;
use Redirect;
use Session;

class CobrosExtraordinariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cobro.extraordinario');
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
        $descripcion_extr = $request['descripcion_extr'];
        $monto = $request['monto'];
        $cliente_extr = $request['cliente_extr'];

        if ($request['exterior']) {
            $destino = 1;
        } else {
            $destino = 0;
        }

        $id_detalle_institucion = InstitucionDetalle::where('nombre_division', '=', 'Todo')
                                                    ->where('id_institucion', '=', $id_institucion)
                                                    ->first()->id;

        $id_categoria = Categoria::where('tipo', '=', 'cobro_extraordinario')
                                 ->where('destino', '=', $destino)
                                 ->where('id_detalle_institucion', '=', $id_detalle_institucion)
                                 ->first()->id;

        $id_deuda = Deuda_Ingreso::create([
            'saldo' => $monto,
            'cliente_extr' => $cliente_extr,
            'descripcion_extr' => $descripcion_extr,
            'id_categoria' => $id_categoria,
        ])->id;

        $mensaje = 'El cobro fue creado exitosamente. El código de pago es: ' . $id_deuda;

        Session::flash('message', $mensaje);
        return Redirect::to('/admin/cobros/extraordinarios');
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
