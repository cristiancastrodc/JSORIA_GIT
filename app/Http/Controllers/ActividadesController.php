<?php

namespace JSoria\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use JSoria\Http\Controllers\Controller;

use JSoria\Http\Requests;
use JSoria\Http\Requests\ActividadesCreateRequest;
use JSoria\Http\Requests\ActividadesUpdateRequest;

use JSoria\Alumno;
use JSoria\Categoria;
use JSoria\Deuda_Ingreso;
use JSoria\InstitucionDetalle;
use JSoria\Usuario_Modulos;

class ActividadesController extends Controller
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
      return view('admin.actividad.index', ['modulos' => $modulos]);
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
    public function store(ActividadesCreateRequest $request)
    {
      $respuesta = [];
      $respuesta['resultado'] = 'true';
      try {
        $nombre = $request->input('nombre');
        $monto = $request->input('monto');
        $todas_divisiones = filter_var($request->input('todas_divisiones'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $id_institucion = $request->input('id_institucion');
        $divisiones = [];
        // Recuperar todas las divisiones
        if ($todas_divisiones) {
          $divisiones = InstitucionDetalle::detalleInstitucion($id_institucion);
        }
        else {
          $divisiones = InstitucionDetalle::where('id', $request->input('id_division'))->get();
        }
        // Recuperar el nro. del batch
        $batch = Categoria::siguienteNroBatch();
        $respuesta['batch'] = $batch;
        // Iniciar transacción de BD
        DB::beginTransaction();
        // Crear la actividad para cada division y agregar deudas
        foreach ($divisiones as $division) {
          // Crear la actividad
          $id_categoria = Categoria::create([
                            'nombre' => $nombre,
                            'monto' => $monto,
                            'tipo' => 'actividad',
                            'estado' => 1,
                            'id_detalle_institucion' => $division->id,
                            'batch' => $batch,
                          ])->id;
          // Usando el id de la actividad, crear deudas
          $alumnos = Alumno::alumnosParaCreacionActividades($division->id, $monto, $id_categoria);
          Deuda_Ingreso::insert($alumnos);
        }
        // Si no hubo errores, finalizar la transacción
        DB::commit();
      } catch (\Exception $e) {
        // Abortar la transacción
        DB::rollBack();
        $respuesta['resultado'] = false;
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
    public function update(ActividadesUpdateRequest $request, $id)
    {
        $categoria = Categoria::find($id);

        $operacion = $request['operacion'];

        if ($operacion == 'actualizar') {
            $categoria->nombre = $request['nombre'];
            $categoria->monto = $request['monto'];
            $categoria->save();

            /* Actualizar deudas relacionadas */
            Deuda_Ingreso::where('id_categoria', '=', $id)->where('estado_pago', '=', 0)->update(['saldo' => $request['monto']]);
        } elseif ($operacion == 'estado') {
            $categoria->estado = $request['estado'];
            $categoria->save();
        }

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    /*
    * Listar actividades
    */
    public function listaActividades(Request $request, $id_detalle_institucion) {
        if ($request->ajax()) {
            $actividades = Categoria::actividadesDetalle($id_detalle_institucion);
            return response()->json($actividades);
        }
    }

    /**
     * Muestra el resumen de creación de la actividad.
     *
     * @param  int  $batch
     * @return \Illuminate\Http\Response
     */
    public function mostrarResumenActividad($batch)
    {
      $modulos = Usuario_Modulos::modulosDeUsuario();
      $actividades = Categoria::resumenActividad($batch);
      return view('admin.actividad.resumen', [
        'modulos' => $modulos,
        'actividades' => $actividades,
      ]);
    }
}
