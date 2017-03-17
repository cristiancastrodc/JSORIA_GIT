<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\AutorizacionCreateRequest;
use JSoria\Http\Controllers\Controller;
use Session;
use Redirect;

use JSoria\Autorizacion;

class CodigoAutorizacionController extends Controller
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
      return view('admin.autorizacion.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AutorizacionCreateRequest $request)
    {
      $respuesta = [];
      $respuesta['resultado'] = 'true';
      $respuesta['FECHA'] = $request->fecha_limite;
      try {
        Autorizacion::create([
          'rd' => $request->resolucion,
          'estado' => 0,
          'id_alumno' => $request->nro_documento,
          'fecha_limite' => $request->fecha_limite == '' ? NULL : $request->fecha_limite,
        ]);
      } catch (\Exception $e) {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = $e->getMessage();
      }
      return $respuesta;
    }

    /**
     * Lista las autorizaciones de acuerdo a los filtros indicados.
     *
     * @param  $nro_documento
     * @param  $fecha_creacion
     * @return \Illuminate\Http\Response
     */
    public function listar($nro_documento, $fecha_creacion = '')
    {
      if ($nro_documento == 'nro_documento_is_null') $nro_documento = '';
      $autorizaciones = Autorizacion::listar($nro_documento, $fecha_creacion);
      return $autorizaciones;
    }

    /**
     * Elimina una autorización.
     *
     * @param  $nro_documento
     * @return \Illuminate\Http\Response
     */
    public function eliminar($id_autorizacion)
    {
      $respuesta = [];
      Autorizacion::destroy($id_autorizacion);
      $respuesta['resultado'] = 'true';
      return $respuesta;
    }
}
