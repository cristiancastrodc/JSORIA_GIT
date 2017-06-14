<?php

namespace JSoria\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use JSoria\Comprobante;
use JSoria\Deuda_Ingreso;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

class DeudaIngresoController extends Controller
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
    $respuesta = [];
    $tipo_ingreso = $request['tipo_ingreso'];
    switch ($tipo_ingreso) {
      case 'multiple':
        DeudaIngresoController::guardarIngresoMultiple($request, $respuesta);
        break;
    }
    return $respuesta;
  }

  public function guardarIngresoMultiple(Request $request, &$respuesta)
  {
    try {
      $categoria = $request['categoria'];
      $cliente = $request['cliente'];
      $comprobante = $request['comprobante'];
      //
      $cliente_extr = '';
      $descripcion_extr = '';
      if ($comprobante['tipo'] == 'comprobante' || $comprobante['tipo'] == 'boleta') {
        $cliente_extr = $cliente['dni'];
        $descripcion_extr = $cliente['nombre'];
      } else {
        $cliente_extr = $cliente['ruc'];
        $descripcion_extr = $cliente['razon_social'] . ' - ' . $cliente['direccion'];
      }
      // Crear el ingreso
      DB::beginTransaction();
      Deuda_Ingreso::create([
        'saldo' => $categoria['monto'],
        'estado_pago' => 1,
        'cliente_extr' => $cliente_extr,
        'descripcion_extr' => $descripcion_extr,
        'fecha_hora_ingreso' => date('Y-m-d H:i:s'),
        'id_categoria' => $categoria['id'],
        'id_cajera' => Auth::user()->id,
        'tipo_comprobante' => $comprobante['tipo'],
        'serie_comprobante' => $comprobante['serie'],
        'numero_comprobante' => $comprobante['numero'],
      ]);
      // Actualizar el comprobante
      Comprobante::actualizar($categoria['id_institucion'], $comprobante['tipo'], $comprobante['serie'], $comprobante['numero']);
      DB::commit();
      $respuesta['resultado'] = 'true';
    } catch (\Exception $e) {
      DB::rollback();
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = $e->getMessage();
    }
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
