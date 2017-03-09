<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\AutorizacionCreateRequest;
use JSoria\Http\Controllers\Controller;

use JSoria\Autorizacion;
use Session;
use Redirect;
use JSoria\Usuario_Modulos;

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
        $modulos = Usuario_Modulos::modulosDeUsuario();
        return view('admin.autorizacion.index', ['modulos' => $modulos]);
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
      try {
        Autorizacion::create([
          'rd' => $request->resolucion,
          'estado' => 0,
          'id_alumno' => $request->nro_documento,
          'fecha_limite' => $request->fecha_limite,
        ]);
      } catch (\Exception $e) {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = $e->getMessage();
      }
      return $respuesta;
    }
}
