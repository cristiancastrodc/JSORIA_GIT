<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use JSoria\Categoria;
use JSoria\Deuda_Ingreso;
use JSoria\Http\Controllers\Controller;
use JSoria\Http\Requests;
use JSoria\Http\Requests\OtrosCobrosCreateRequest;
use JSoria\Http\Requests\OtrosCobrosUpdateRequest;
use JSoria\InstitucionDetalle;
use Redirect;
use Session;

class OtrosCobrosController extends Controller
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
      return view('admin.cobro.otro', compact('categories'));
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(OtrosCobrosCreateRequest $request)
  {
    $respuesta = [];
    $respuesta['resultado'] = 'false';
    try {
      $id_detalle = InstitucionDetalle::todoDeInstitucion($request['id_institucion'])->id;
      $destino = filter_var($request->input('destino'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
      $estado = filter_var($request->input('estado'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
      $nombre = $request['nombre'];
      $monto = $request['monto'];

      Categoria::create([
          'id_detalle_institucion' => $id_detalle,
          'nombre' => $nombre,
          'monto' => $monto,
          'tipo' => 'multiple',
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
  public function update(OtrosCobrosUpdateRequest $request, $id)
  {
    $respuesta = [];
    try {
      $categoria = Categoria::find($id);
      if ($categoria) {
        DB::beginTransaction();
        $categoria->nombre = $request->input('nombre');
        $categoria->monto = $request->input('monto');
        $estado = filter_var($request->input('estado'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $categoria->estado = $estado;
        $categoria->save();
        $respuesta['resultado'] = 'true';
        DB::commit();
      } else {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = 'Cobro no existe.';
      }
    } catch (\Exception $e) {
      DB::rollBack();
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
  }
  /*
  * Listar cobros
  */
  public function listaCobros(Request $request, $id_institucion = '')
  {
    return Categoria::otrosCobrosInstitucion($id_institucion);
  }
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $respuesta = [];
    try {
      $deudas = Deuda_Ingreso::where('id_categoria', $id)->count() > 0;
      if ($deudas) {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = 'Este Cobro está asociado a una o más deudas.';
      } else {
        Categoria::destroy($id);
        $respuesta['resultado'] = 'true';
      }
    } catch (\Exception $e) {
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
  }
}
