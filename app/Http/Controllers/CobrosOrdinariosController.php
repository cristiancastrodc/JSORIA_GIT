<?php

namespace JSoria\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use JSoria\Categoria;
use JSoria\Http\Requests;
use JSoria\Http\Requests\CobroOrdinarioCreateRequest;
use JSoria\Http\Requests\CobroOrdinarioUpdateRequest;
use JSoria\Http\Controllers\Controller;
use JSoria\InstitucionDetalle;
use Redirect;
use Session;

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
    return view('admin.cobro.ordinario', compact('categories'));
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
      $id_detalle = InstitucionDetalle::todoDeInstitucion($request->input('id_institucion'))->id;
      $nombre = $request->input('nombre');
      $monto = $request->input('monto');
      $con_factor = filter_var($request->input('con_factor'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
      $tipo = $con_factor ? 'con_factor' : 'sin_factor';
      $destino = filter_var($request->input('destino'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
      $estado = filter_var($request->input('estado'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
      // Crear el cobro ordinario
      Categoria::create([
        'id_detalle_institucion' => $id_detalle,
        'nombre' => $nombre,
        'monto' => $monto,
        'tipo' => $tipo,
        'destino' => $destino,
        'estado' => $estado,
      ]);
      $respuesta['resultado'] = 'true';
    } catch (\Exception $e) {
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
  public function update(CobroOrdinarioUpdateRequest $request, $id)
  {
    $respuesta = [];
    try {
      $categoria = Categoria::find($id);
      if ($categoria) {
        DB::beginTransaction();
        $con_factor = filter_var($request->input('con_factor'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $tipo = $con_factor ? 'con_factor' : 'sin_factor';
        $estado = filter_var($request->input('estado'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $categoria->nombre = $request->input('nombre');
        $categoria->monto = $request->input('monto');
        $categoria->tipo = $tipo;
        $categoria->estado = $estado;
        $categoria->save();
        $respuesta['resultado'] = 'true';
        DB::commit();
      } else {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = 'Cobro Ordinario no existe.';
      }
    } catch (\Exception $e) {
      DB::rollBack();
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
  }
  /*
  * Retorna la lista de cobros ordinarios.
  */
  public function listaCobros($id_institucion = '') {
    return Categoria::cobrosOrdinariosInstitucion($id_institucion);
  }
}
