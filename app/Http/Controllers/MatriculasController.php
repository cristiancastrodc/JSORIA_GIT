<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;
use JSoria\Http\Requests;
use JSoria\Http\Requests\MatriculaCreateRequest;
use JSoria\Http\Requests\MatriculaUpdateRequest;
use JSoria\Http\Controllers\Controller;
use JSoria\Categoria;
use JSoria\CategoriaTemp;
use JSoria\Deuda_Ingreso;

class MatriculasController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('admin', ['except' => ['programarPeriodos', 'recuperarMatriculas', 'crearMatriculaPensiones']]);
    $this->middleware('Secretaria', ['only' => ['programarPeriodos', 'recuperarMatriculas', 'crearMatriculaPensiones']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('admin.matricula.index');
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
  public function store(MatriculaCreateRequest $request)
  {
    if ($request->ajax()) {
      Categoria::create($request->all());
      return response()->json([
        'mensaje' => 'Matrícula creada exitosamente.'
      ]);
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
    return view('admin.usuario.edit', ['user' => $this->user]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(MatriculaUpdateRequest $request, $id)
  {
    $categoria = Categoria::find($id);

    $operacion = $request['operacion'];

    if ($operacion == 'actualizar') {
      $categoria->nombre = $request['nombre'];
      $categoria->monto = $request['monto'];
      $categoria->save();

      /* Mofidicar deudas de matricula */
      Deuda_Ingreso::where('id_categoria', '=', $id)->where('estado_pago', '=', 0)->update(['saldo' => $request['monto']]);
    } elseif ($operacion == 'estado') {
      $categoria->estado = $request['estado'];
      $categoria->save();
    }

    return response()->json([
      'mensaje' => 'actualizado'
    ]);
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

  public function listaMatriculas(Request $request, $id_institucion, $anio) {
    if ($request->ajax()) {
      $matriculas = Categoria::matriculasInstitucionAnio($id_institucion, $anio);
      return response()->json($matriculas);
    } else {
      return view('errors.403');
    }
  }

  /**
   * Mostrar el módulo para crear una matrícula conjuntamente con sus pensiones.
   */
  public function crearMatricula()
  {
    return view('admin.matricula.crear');
  }

  /**
   * Almacenar la matrícula junto con las pensiones
   */
  public function guardarMatricula(Request $request)
  {
    $resultado = 'true';
    try {
      // Recuperar los datos
      $id_institucion = $request->input('id_institucion');
      $matricula = $request->input('matricula');
      $pensiones = $request->input('pensiones');
      $divisiones = $request->input('divisiones');
      $periodo = $request->input('periodo');
      $definir_fechas = $request->input('definir_fechas');
      // -- Datos de Matricula
      $matricula_concepto = $matricula['concepto'];
      // Datos de Pensiones
      $pensiones_concepto = $pensiones['concepto'];
      // El almacenamiento es diferente en caso se definan o no las fechas
      if ($definir_fechas === 'true') {
        // -- Datos de Matricula
        $matricula_fecha_inicio = $matricula['fecha_inicio'];
        $matricula_fecha_fin = $matricula['fecha_fin'];
        // Datos de Pensiones
        $pensiones_mes_inicio = $pensiones['mes_inicio'];
        $tokens = explode('/', $pensiones_mes_inicio);
        $mes_inicio = $tokens[0];
        $anio_inicio = $tokens[1];
        $inicio = intval($anio_inicio) * 100 + intval($mes_inicio);
        $pensiones_mes_fin = $pensiones['mes_fin'];
        $tokens = explode('/', $pensiones_mes_fin);
        $mes_fin = $tokens[0];
        $anio_fin = $tokens[1];
        $fin = intval($anio_fin) * 100 + intval($mes_fin);
        // Crear matrícula y pensiones
        $cuenta = 0;
        foreach ($divisiones as $division) {
          if (isset($division['seleccionar']) && $division['seleccionar']) {
            $inicio = intval($anio_inicio) * 100 + intval($mes_inicio);
            // Crear la matrícula
            $id_matricula = Categoria::create([
                                'nombre' => $matricula_concepto,
                                'monto' => $division['monto_matricula'],
                                'tipo' => 'matricula',
                                'estado' => '1',
                                'fecha_inicio' => $matricula_fecha_inicio,
                                'fecha_fin' => $matricula_fecha_fin,
                                'destino' => '0',
                                'id_detalle_institucion' => $division['id'],
                                'periodo' => $periodo,
                            ])->id;
            // Crear las pensiones
            $meses2 = array(0, 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto' , 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
            while ($inicio <= $fin) {
              $mes = substr($inicio, -2);
              $anio = substr($inicio, 0, 4);
              $cat_concepto = $pensiones_concepto . ' ' . $meses2[intval($mes)] . ' ' . $anio;
              $cat_fecha_inicio = $anio . '-' . $mes . '-01';
              $cat_fecha_fin = date('Y-m-t', strtotime($cat_fecha_inicio));
              Categoria::create([
                  'nombre' => $cat_concepto,
                  'monto' => $division['monto_pensiones'],
                  'tipo' => 'pension',
                  'estado' => '1',
                  'fecha_inicio' => $cat_fecha_inicio,
                  'fecha_fin' => $cat_fecha_fin,
                  'destino' => '0',
                  'id_detalle_institucion' => $division['id'],
                  'id_matricula' => $id_matricula,
                  'periodo' => $periodo,
                  ]);
              if (intval($mes) == 12) {
                  $inicio += 89;
              } else {
                  $inicio += 1;
              }
            };
          }
        }
      } else {
        foreach ($divisiones as $division) {
          if (isset($division['seleccionar']) && $division['seleccionar']) {
            $matricula_regular = $matricula_concepto;
            if (isset($division['crear_ingresantes']) && $division['crear_ingresantes']) {
              $matricula_regular .= ' - Alumno Regular';
            }
            CategoriaTemp::create([
              'id_detalle_institucion' => $division['id'],
              'estado' => 0,
              'monto_matricula' => $division['monto_matricula'],
              'monto_pension' => $division['monto_pensiones'],
              'concepto_matricula' => $matricula_regular,
              'concepto_pension' => $pensiones_concepto,
              'periodo' => $periodo,
              ]);
            if (isset($division['crear_ingresantes']) && $division['crear_ingresantes']) {
              CategoriaTemp::create([
                'id_detalle_institucion' => $division['id'],
                'estado' => 0,
                'monto_matricula' => $division['monto_matricula'],
                'monto_pension' => $division['monto_pensiones'],
                'concepto_matricula' => $matricula_concepto . ' - Alumno Ingresante',
                'concepto_pension' => $pensiones_concepto,
                'periodo' => $periodo,
                ]);
            }
          }
        }
      }
    } catch (\Exception $e) {
      $resultado = $e->getMessage();
    }
    return $resultado;
  }

  /**
   * Mostrar la vista para programar los períodos
   */
  public function programarPeriodos()
  {
    return view('secretaria.matricula.programar');
  }

  /**
   * Mostrar la vista para programar los períodos
   */
  public function recuperarMatriculas($id_institucion)
  {
    return CategoriaTemp::categoriasParaProgramar($id_institucion);
  }

  /**
   * Mostrar la vista para programar los períodos
   */
  public function crearMatriculaPensiones(Request $request)
  {
    $resultado = 'true';
    try {
      // Recuperar los datos
      $matriculas = $request->input('matriculas');
      foreach ($matriculas as $matricula) {
        // -- Datos de Matricula
        $matricula_concepto = $matricula['concepto_matricula'];
        $matricula_fecha_inicio = $matricula['fecha_inicial'];
        $matricula_fecha_fin = $matricula['fecha_final'];
        // Datos de Pensiones
        $pensiones_concepto = $matricula['concepto_pension'];
        // -- Mes inicial
        $pensiones_mes_inicio = $matricula['mes_inicial_pension'];
        $tokens = explode('/', $pensiones_mes_inicio);
        $mes_inicio = $tokens[0];
        $anio_inicio = $tokens[1];
        $inicio = intval($anio_inicio) * 100 + intval($mes_inicio);
        // -- Mes final
        $pensiones_mes_fin = $matricula['mes_final_pension'];
        $tokens = explode('/', $pensiones_mes_fin);
        $mes_fin = $tokens[0];
        $anio_fin = $tokens[1];
        $fin = intval($anio_fin) * 100 + intval($mes_fin);
        // Crear matrícula y pensiones
        $cuenta = 0;
        // Crear la matrícula
        $id_matricula = Categoria::create([
                            'nombre' => $matricula_concepto,
                            'monto' => $matricula['monto_matricula'],
                            'tipo' => 'matricula',
                            'estado' => '1',
                            'fecha_inicio' => $matricula_fecha_inicio,
                            'fecha_fin' => $matricula_fecha_fin,
                            'destino' => '0',
                            'id_detalle_institucion' => $matricula['id_detalle_institucion'],
                            'periodo' => $matricula['periodo'],
                        ])->id;
        // Crear las pensiones
        $meses2 = array(0, 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto' , 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        while ($inicio <= $fin) {
          $mes = substr($inicio, -2);
          $anio = substr($inicio, 0, 4);
          $cat_concepto = $pensiones_concepto . ' ' . $meses2[intval($mes)] . ' ' . $anio;
          $cat_fecha_inicio = $anio . '-' . $mes . '-01';
          $cat_fecha_fin = date('Y-m-t', strtotime($cat_fecha_inicio));
          Categoria::create([
              'nombre' => $cat_concepto,
              'monto' => $matricula['monto_pension'],
              'tipo' => 'pension',
              'estado' => '1',
              'fecha_inicio' => $cat_fecha_inicio,
              'fecha_fin' => $cat_fecha_fin,
              'destino' => '0',
              'id_detalle_institucion' => $matricula['id_detalle_institucion'],
              'id_matricula' => $id_matricula,
              'periodo' => $matricula['periodo'],
              ]);
          if (intval($mes) == 12) {
              $inicio += 89;
          } else {
              $inicio += 1;
          }
        }
        // Actualizar el estado de la categoría temporal
        $categoria_temp = CategoriaTemp::find($matricula['id']);
        $categoria_temp->estado = 1;
        $categoria_temp->save();
      }
    } catch (\Exception $e) {
      $resultado = $e->getMessage();
    }
    return $resultado;
  }
}
