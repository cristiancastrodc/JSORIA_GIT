<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests\CobroExtCreateRequest;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Deuda_Ingreso;
use JSoria\Categoria;
use JSoria\InstitucionDetalle;
use Redirect;
use Session;
use JSoria\Usuario_Modulos;

class CobrosExtraordinariosController extends Controller
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
        return view('admin.cobro.extraordinario', ['modulos' => $modulos]);
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
    public function store(CobroExtCreateRequest $request)
    {

      $respuesta = [];
      $respuesta['resultado'] = 'false';
      try {
        $id_detalle = InstitucionDetalle::todoDeInstitucion($request['id_institucion'])->id;
        $descripcion_extr = $request['descripcion_extr'];
        $monto = $request['monto'];
        $cliente_extr = $request['cliente_extr'];
        $destino = $request['destino'] ? '1' : '0';
        // Recuperar id de la categoria indicada
        $id_categoria = Categoria::categoriaExtraordinaria($id_detalle, $destino)->id;

        $id_deuda = Deuda_Ingreso::create([
                      'saldo' => $monto,
                      'cliente_extr' => $cliente_extr,
                      'descripcion_extr' => $descripcion_extr,
                      'id_categoria' => $id_categoria,
                    ])->id;
        $respuesta['resultado'] = 'true';
        $respuesta['id_deuda'] = $id_deuda;
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
     * Listar cobros extraordinarios
     */
    public function listaCobros(Request $request, $id_institucion)
    {
      if ($request->ajax()) {
        $cobros = Categoria::cobrosExtraordinariosInstitucion($id_institucion);
        return response()->json($cobros);
      }
    }
    /**
     * Listar cobros extraordinarios
     */
    public function eliminarCobro($id_cobro)
    {
      Deuda_Ingreso::destroy($id_cobro);
    }
}
