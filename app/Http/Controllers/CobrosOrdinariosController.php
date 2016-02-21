<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\CobroOrdinarioCreateRequest;
use JSoria\Http\Controllers\Controller;

use JSoria\Categoria;
use JSoria\InstitucionDetalle;
use Redirect;
use Session;

class CobrosOrdinariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*** Mostrar lista de usuarios ***/
        $categories = Categoria::All();
        return view('admin.cobro.ordinario', compact('categories'));
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
    public function store(CobroOrdinarioCreateRequest $request)
    {
        $id = InstitucionDetalle::where('id_institucion', '=', $request['id_institucion'])->where('nombre_division', '=', 'Todo')->first()->id;
        $factor = $request['unitario'];
        $otracuenta = $request['exterior'];
        $habilitado = $request['habilitado'];
        if ($factor) {
            $fac = 'con_factor';
        } else {
            $fac = 'sin_factor';
        }
        if ($otracuenta) {
            $destino = '1';
        } else {
            $destino = '0';
        }
        if ($habilitado) {
            $estado = '1';
        } else {
            $estado = '0';
        }
        Categoria::create([
            'id_detalle_institucion' => $id,
            'nombre' => $request-> nombre,
            'monto' => $request-> monto,
            'tipo' => $fac,
            'destino' => $destino,
            'estado' => $estado,
            ]);


        Session::flash('message', 'Cobro Ordinario creado correctamente.');
        return Redirect::to('/admin/cobros/ordinarios');
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
        if ($request->ajax()) {
            $nombre = $request['nombre'];
            $monto = $request['monto'];
            $tipo = $request['unitario'] == "true" ? 'con_factor' : 'sin_factor';
            $estado = $request['estado'] == "true" ? 1 : 0;

            Categoria::find($id)->update(['nombre' => $nombre, 'monto' => $monto, 'tipo' => $tipo, 'estado' => $estado]);

            return response()->json(['mensaje' => 'Actualizado']);
        } else {
            return response()->json(['mensaje' => 'Request not AJAX.']);
        }
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
    public function listaCobros(Request $request, $id_institucion) {
        if ($request->ajax()) {
            $cobros_ordinarios = Categoria::cobrosOrdinariosInstitucion($id_institucion);
            return response()->json($cobros_ordinarios);
        }
    }
}
