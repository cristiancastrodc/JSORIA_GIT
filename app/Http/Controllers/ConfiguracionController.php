<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\UsuarioImpresora;
use Auth;

class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /*** Vista de Configuracion de Cajera ***/
    public function cajeraImpresora()
    {
        return view('cajera.conf.impresora');
    }

    /*** Guardar configuracion de Impresora de Cajera ***/
    public function guardarCajeraImpresora(Request $request)
    {
        if ($request->ajax()) {
            $tipo_impresora = $request->tipo_impresora;

            $configuracion = UsuarioImpresora::where('id_cajera', Auth::user()->id)
                             ->first();

            if ($tipo_impresora == 'matricial') {
                $nombre_impresora = '//localhost/Matricial';
            } else if ($tipo_impresora == 'ticketera') {
                $nombre_impresora = 'Ticketera';
            }

            if ($configuracion) {
                $configuracion->tipo_impresora = $tipo_impresora;
                $configuracion->nombre_impresora = $nombre_impresora;
                $configuracion->save();

                return response()->json(['mensaje' => 'Actualizados la configuración de impresora.']);
            } else {
                UsuarioImpresora::create([
                    'id_cajera' => Auth::user()->id,
                    'tipo_impresora' => $tipo_impresora,
                    'nombre_impresora' => $nombre_impresora
                ]);
                return response()->json(['mensaje' => 'Se creó la configuración de impresora.']);
            }
        }
    }
}
