<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\CobroOrdinarioCreateRequest;
use JSoria\Http\Requests\CobroOrdinarioUpdateRequest;
use JSoria\Http\Controllers\Controller;

use JSoria\Categoria;
use JSoria\InstitucionDetalle;
use Redirect;
use Session;
use JSoria\Usuario_Modulos;


class CobrosOrdinariosController extends Controller
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
        /*** Mostrar lista de usuarios ***/
        $categories = Categoria::All();
        $modulos = Usuario_Modulos::modulosDeUsuario();
        return view('admin.cobro.ordinario', compact('categories', 'modulos'));
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
      $respuesta = [];
      $respuesta['resultado'] = 'false';
      try {
        $id_detalle = InstitucionDetalle::todoDeInstitucion($request['id_institucion'])->id;
        $nombre = $request['nombre'];
        $monto = $request['monto'];
        $con_factor = $request['con_factor'];
        $tipo = $con_factor ? 'con_factor' : 'sin_factor';
        $destino = $request['destino'] ? '1' : '0';
        $estado = $request['estado'] ? '1' : '0';

        Categoria::create([
          'id_detalle_institucion' => $id_detalle,
          'nombre' => $nombre,
          'monto' => $monto,
          'tipo' => $tipo,
          'destino' => $destino,
          'estado' => $estado,
        ]);
        $respuesta['resultado'] = 'true';
      } catch (Exception $e) {
        $respuesta['mensaje'] = $e->getMessage();
      }

      return $respuesta;
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
    public function update(CobroOrdinarioUpdateRequest $request, $id)
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

    public function imprimir()
    {


    }
}
