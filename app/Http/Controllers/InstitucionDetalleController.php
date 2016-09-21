<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\InstitucionDetalle;

class InstitucionDetalleController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      
    }
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

    public function divisionesInstitucion(Request $request, $id_institucion)
    {
        if ($request->ajax()) {
            $divisiones = InstitucionDetalle::divisiones_institucion($id_institucion);
            return response()->json($divisiones);
        }
    }

    public function gradosDetalle(Request $request, $id_detalle_institucion)
    {
        if ($request->ajax()) {
            $grados = InstitucionDetalle::grados_detalle($id_detalle_institucion);
            return response()->json($grados);
        }
    }
    public function matriculas(Request $request, $id_detalle_institucion)
    {
        if ($request->ajax()) {
            $matricula = InstitucionDetalle::matricula($id_detalle_institucion);
            return response()->json($matricula);
        }
    }

    /*
     * Retorna la colección de divisiones para poblar los select (html)
     */
    public function detalleInstitucionParaSelect($id_institucion)
    {
        return InstitucionDetalle::divisionesParaSelect($id_institucion);
    }
}
