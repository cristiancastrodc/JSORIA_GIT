<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;
use JSoria\Categoria;
use JSoria\Deuda_Ingreso;
use JSoria\Http\Requests\CobroExtCreateRequest;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;
use JSoria\InstitucionDetalle;
use Redirect;
use Session;

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
    return view('admin.cobro.extraordinario');
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
      $destino = filter_var($request->input('destino'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
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
    } catch (\Exception $e) {
      $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
  }
  /**
   * Listar cobros extraordinarios
   */
  public function listaCobros($id_institucion = '')
  {
    return Categoria::cobrosExtraordinariosInstitucion($id_institucion);
  }
  /**
   * Listar cobros extraordinarios
   */
  public function eliminarCobro($id_cobro)
  {
    $respuesta = [];
    try {
      Deuda_Ingreso::destroy($id_cobro);
      $respuesta['resultado'] = 'true';
    } catch (\Exception $e) {
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
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
    $respuesta = [];
    try {
      $deuda = Deuda_Ingreso::find($id);
      if ($deuda) {
        $deuda->descripcion_extr = $request->input('descripcion_extr');
        $deuda->cliente_extr = $request->input('cliente_extr');
        $deuda->saldo = $request->input('monto');
        $deuda->save();
        $respuesta['resultado'] = 'true';
      } else {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = 'Cobro no existe.';
      }
    } catch (\Exception $e) {
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
  }
}
