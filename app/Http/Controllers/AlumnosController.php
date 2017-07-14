<?php

namespace JSoria\Http\Controllers;

use Auth;
use DB;
use Crypt;
use Illuminate\Http\Request;
use JSoria\Alumno;
use JSoria\Autorizacion;
use JSoria\Categoria;
use JSoria\Deuda_Ingreso;
use JSoria\Grado;
use JSoria\Http\Requests;
use JSoria\Http\Requests\AlumnoCreateRequest;
use JSoria\Http\Requests\AlumnoUpdateRequest;
use JSoria\Http\Controllers\Controller;
use JSoria\InstitucionDetalle;
use JSoria\Institucion;
use JSoria\Permiso;
use Redirect;
use Session;

class AlumnosController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('Secretaria', ['except' => ['recuperarAlumno']]);
    $this->middleware('admin', ['only' => ['recuperarAlumno']]);
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('secretaria.alumno.create');
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(AlumnoCreateRequest $request)
  {
    try {
      $tipo_documento = $request['tipo_documento'];
      $nro_documento = $tipo_documento == 'dni' ? trim($request['nro_documento_dni']) : trim($request['nro_documento_otro']);
      if (!Alumno::find($nro_documento)) {
        Alumno::create([
          'tipo_documento' =>$tipo_documento,
          'nro_documento' => $nro_documento,
          'nombres' => $request['nombres'],
          'apellidos' => $request['apellidos'],
        ]);
        $matricular = filter_var($request['matricular'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE );
        if ($matricular) {
          Session::flash('message', 'Alumno creado exitosamente. Puede crear su cuenta.');
          return redirect('/secretaria/alumno/matricular')->with('nro_documento', $nro_documento);
        } else {
          Session::flash('message', 'Alumno registrado correctamente.');
          Session::flash('message-class', 'success');
          return redirect()->back();
        }
      } else {
        Session::flash('message', 'El número de documento ingresado ya existe.');
        Session::flash('message-class', 'danger');
        return redirect()->back();
      }
    } catch (\Exception $e) {
      Session::flash('message', $e->getMessage());
      Session::flash('message-class', 'danger');
      return redirect()->back();
    }
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(AlumnoUpdateRequest $request, $nro_documento)
  {
    if ($request->ajax()) {
      $alumno = Alumno::find($nro_documento);

      $id_grado = $request['id_grado'];
      $id_matricula = $request['id_matricula'];
      $id_detalle_institucion = $request['id_detalle_institucion'];

      $alumno->estado = '1';
      $alumno->id_grado = $id_grado;

      $alumno->save();

      /*** Agregar las deudas del alumno ***/
      $matricula = Categoria::find($id_matricula);
      Deuda_Ingreso::create([
        'saldo' => $matricula->monto,
        'id_categoria' => $matricula->id,
        'id_alumno' => $nro_documento,
      ]);
      $hoy = date('Y-m-d');
      $pensiones = Categoria::where('tipo', '=', 'pension')
                  ->where('id_matricula', '=', $id_matricula)
                  ->where('estado', '=', 1)
                  ->where('id_detalle_institucion', '=', $id_detalle_institucion)
                  ->where('fecha_fin','>=', $hoy)
                  ->get();

      foreach ($pensiones as $pension) {
        Deuda_Ingreso::create([
          'saldo' => $pension->monto,
          'id_categoria' => $pension->id,
          'id_alumno' => $nro_documento,
        ]);
      }

      return response()->json([
        'mensaje' => 'Se crearon los pagos del alumno.'
      ]);
    }
  }
  /**
  * Matricular a un alumno
  **/
  public function matricular()
  {
    $permisos = Permiso::join('institucion', 'permisos.id_institucion', '=', 'institucion.id')
                       ->where('permisos.id_usuario', '=', Auth::user()->id)
                       ->select('institucion.id', 'institucion.nombre')->get();
    return view('secretaria.alumno.matricular', ['permisos' => $permisos]);
  }
  /**
  * Agregar deudas
  **/
  public function agregarDeuda()
  {
    return view('secretaria.alumno.deuda.agregar');
  }
  /**
  * Modificar deudas
  **/
  public function deudas()
  {
    return view('secretaria.alumno.deuda.index');

  }
  /**
  * Cancelar deudas de actividad
  **/
  public function cancelarDeudaActividad()
  {
    return view('secretaria.alumno.deuda.cancelar');
  }
  /**
  * Autorizar amortización
  **/
  public function amortizacion()
  {
    return view('secretaria.alumno.deuda.amortizacion');
  }
  public function datosAlumno(Request $request, $dni)
  {
    if ($request->ajax()) {
      $alumno = Alumno::datos_alumno($dni);
      if ($alumno) {
        if ($alumno->estado == 0) {
          return response()->json($alumno);
        } else {
          return response()->json([
            'mensaje' => 'CUIDADO!. El alumno ya esta matriculado.'
          ]);
        }
      } else {
        return response()->json([
          'mensaje' => 'EL ALUMNO NO ESTA REGISTRADO.'
        ]);
      }
    }
  }
  public function categoriasAlumno(Request $request, $documento)
  {
    if ($request->ajax()) {
    $alumno = Alumno::join('grado','alumno.id_grado','=','grado.id')
            ->join('detalle_institucion','grado.id_detalle','=','detalle_institucion.id' )
            ->join('institucion','detalle_institucion.id_institucion','=','institucion.id')
            ->where('alumno.nro_documento','=',$documento)
            ->select('alumno.estado', 'alumno.nombres', 'alumno.apellidos', 'grado.id_detalle', 'grado.nombre_grado', 'alumno.nro_documento', 'detalle_institucion.nombre_division', 'institucion.nombre')
            ->first();

    if ($alumno) {
      if ($alumno->estado == 1) {
      $id_institucion = InstitucionDetalle::find($alumno->id_detalle)->id_institucion;

      $detalle_institucion = InstitucionDetalle::where('id_institucion', '=', $id_institucion)
                           ->where('nombre_division', '=', 'Todo')
                           ->first()->id;

      $categorias = Categoria::whereIn('tipo', ['con_factor', 'sin_factor'])
                   ->where('estado', '=', 1)
                   ->where('id_detalle_institucion','=', $detalle_institucion)
                   ->get();
      $response = array($alumno, $categorias);
      return response()->json($response);
      } else {
      return response()->json([
        'mensaje' => 'El alumno no esta matriculado.'
      ]);
      }
    } else {
      return response()->json([
      'mensajeno' => 'El alumno no existe.'
      ]);
    }
    }
  }

  public function listaDeudasAlumno(Request $request, $nro_documento)
  {
    $respuesta = [];
    try {
      $alumno = Alumno::recuperarAlumno($nro_documento);
      if ($alumno) {
        $respuesta['alumno'] = $alumno;
        $respuesta['deudas'] = Deuda_Ingreso::deudasDeAlumnoPorUsuario($nro_documento);
        $respuesta['resultado'] = 'true';
      } else {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = 'No se encuentra registrado el documento del alumno.';
      }
    } catch (\Exception $e) {
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
  }

  public function listaDeudasActividadesAlumno(Request $request, $documento)
  {
    if ($request->ajax()) {

      $alumno = Alumno::join('grado','alumno.id_grado','=','grado.id')
            ->join('detalle_institucion','grado.id_detalle','=','detalle_institucion.id' )
            ->join('institucion','detalle_institucion.id_institucion','=','institucion.id')
            ->where('alumno.nro_documento','=',$documento)
            ->select('alumno.estado', 'alumno.nombres', 'alumno.apellidos', 'grado.id_detalle', 'grado.nombre_grado', 'alumno.nro_documento', 'detalle_institucion.nombre_division', 'institucion.nombre')
            ->first();
      //$alumno = Alumno::where('nro_documento','=',$documento)->first();
      $deudas = Deuda_Ingreso::join('categoria','deuda_ingreso.id_categoria','=','categoria.id')
                   ->where('deuda_ingreso.id_alumno','=',$documento)
                   ->where('deuda_ingreso.estado_pago','=',0)
                   ->where('categoria.tipo','=','actividad')
                   ->select('deuda_ingreso.id','categoria.nombre','deuda_ingreso.saldo','deuda_ingreso.descuento')
                   ->get();
      if ($alumno) {
        if ($alumno->estado == 1) {
          $response = array($alumno, $deudas);
          return response()->json($response);

        } else {
          return response()->json([
            'mensaje' => 'El alumno no esta matriculado.'
          ]);
        }
      } else {
        return response()->json([
          'mensaje' => 'El alumno no existe.'
        ]);
      }
    }
  }


  public function amortizarDeudaAlumno(Request $request, $documento)
  {
    if ($request->ajax()) {

      $alumno = Alumno::where('nro_documento','=',$documento)->first();
      $deudas = Deuda_Ingreso::join('categoria','deuda_ingreso.id_categoria','=','categoria.id')
                   ->where('deuda_ingreso.id_alumno','=',$documento)
                   ->where('deuda_ingreso.estado_pago','=',0)
                   ->where('deuda_ingreso.estado_fraccionam','=',0)
                   ->select('deuda_ingreso.id','categoria.nombre','deuda_ingreso.saldo','deuda_ingreso.descuento')
                   ->get();
      if ($alumno) {
        if ($alumno->estado == 1) {
          $response = array($alumno, $deudas);
          return response()->json($response);

        } else {
          return response()->json([
            'mensaje' => 'El alumno no esta matriculado.'
          ]);
        }
      } else {
        return response()->json([
          'mensaje' => 'El alumno no existe.'
        ]);
      }
    }
  }
  /*** Agregar deudas para un alumno ***/
  public function agregarDeudasAlumno(Request $request)
  {
    $respuesta = [];
    try {
      $nro_documento = $request->input('nro_documento');
      $alumno = Alumno::find($nro_documento);
      if ($alumno) {
        $deudas = $request->input('deudas');
        DB::beginTransaction();
        foreach ($deudas as $deuda) {
          $saldo = floatval($deuda['monto']) * floatval($deuda['factor']);
          Deuda_Ingreso::create([
            'saldo' => $saldo,
            'id_categoria' => $deuda['id'],
            'id_alumno' => $nro_documento,
            'id_matricula' => $alumno->id_matricula,
          ]);
        }
        $respuesta['resultado'] = 'true';
        DB::commit();
      } else {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = 'Código de alumno no registrado.';
      }
    } catch (\Exception $e) {
      DB::rollback();
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
  }

  /*** Eliminar Actividad del alumno ***/
  public function EliminarDeudaActividad(Request $request)
  {
    if ($request->ajax()) {
      $deudasCanceladas = $request->deudasCanceladas;

      foreach ($deudasCanceladas as $deuda) {
        $id_deuda = $deuda['id_deuda'];
        Deuda_Ingreso::where('id','=',$id_deuda)
                ->delete();
      }
      return response()->json(['mensaje' => 'Deuda de actividad del alumno eliminada correctamente.']);
    }
  }

  /**
   * Retorna los datos del alumno para la creación de la matrícula.
   */
  public function datosAlumnoParaMatricula($nro_documento)
  {
    $resultado = 'true';
    $alertar = 'false';
    $mensaje = [];
    $alumno = Alumno::datosAlumno($nro_documento);
    $datosinstitucion = Alumno::recuperarAlumno($nro_documento);
    if ($alumno) {
      if ($alumno->estado == 1) {
        $alertar = 'true';
        $mensaje['titulo']= 'Advertencia';
        $mensaje['contenido'] = 'El alumno ya se encuentra matriculado.';
      }
    } else {
      $resultado = 'false';
      $alertar = 'true';
      $mensaje['titulo'] = 'Error';
      $mensaje['contenido'] = 'No se encuentra registrado el documento del alumno.';
    }
    $respuesta = array(
      'resultado' => $resultado,
      'alertar' => $alertar,
      'mensaje' => $mensaje,
      'alumno' => $alumno,
      'datosinstitucion' => $datosinstitucion,
    );
    return $respuesta;
  }
  /**
   * Almacena los pagos de matrícula y pensiones para un alumno
   */
  public function crearMatricula(Request $request)
  {
    // Variables iniciales
    $resultado = 'true';
    $mensaje = [];
    # Lista de categorías separadas por comas
    $categorias = [];
    try {
      // Recuperar parámetros enviados
      $nro_documento = $request->input('nro_documento');
      $id_grado = $request->input('id_grado');
      $matricula = $request->input('matricula');
      $pensiones = $request->input('pensiones');
      $id_matricula = $matricula['id'];
      // Recuperar alumno y actualizar datos
      $alumno = Alumno::find($nro_documento);
      $alumno->estado = 1;
      $alumno->id_grado = $id_grado;
      $alumno->id_matricula = $id_matricula;
      $alumno->save();
      // Crear deuda de matrícula
      Deuda_Ingreso::create([
        'saldo' => $matricula['monto'],
        'id_categoria' => $matricula['id'],
        'id_alumno' => $nro_documento,
        'id_matricula' => $id_matricula,
      ]);
      # Actualizar la lista de categorías
      array_push($categorias, $matricula['id']);
      // Crear deuda de pensiones
      foreach ($pensiones as $pension) {
        array_push($categorias, $pension['id']);
        Deuda_Ingreso::create([
        'saldo' => $pension['monto'],
        'id_categoria' => $pension['id'],
        'id_alumno' => $nro_documento,
        'id_matricula' => $id_matricula,
        ]);
      }
    } catch (\Exception $e) {
      $resultado = 'false';
      $mensaje['titulo'] = 'Error';
      $mensaje['contenido'] = $e->getMessage();
    }
    $ruta = '/secretaria/matricular/reporte/' . Crypt::encrypt(implode(',', $categorias)) . '/' . $nro_documento . '/' . $id_grado;
    // Retornar respuesta
    $respuesta = array(
      'resultado' => $resultado,
      'mensaje' => $mensaje,
      'ruta' => $ruta,
    );
    return $respuesta;
  }
  /**
   * Almacena los pagos de matrícula y pensiones para un alumno
   */
  public function reporteMatricula($categorias_encriptadas, $nro_documento, $id_grado)
  {
    $categorias_array = explode(',', Crypt::decrypt($categorias_encriptadas));
    $categorias = Categoria::whereIn('id', $categorias_array)->get();
    $total = 0;
    foreach ($categorias as $categoria) {
      $total += $categoria->monto;
    }
    $total = number_format($total, 2);
    $alumno = Alumno::datosAlumno($nro_documento);
    $grado = Grado::find($id_grado);
    $detalle = InstitucionDetalle::find($grado->id_detalle);
    $institucion = Institucion::find($detalle->id_institucion);
    $matricula = $institucion->nombre . ' - ' . $detalle->nombre_division . ' - ' . $grado->nombre_grado;
    $archivo = 'Reporte de Matrícula de Alumno';
    $fecha = date('d-m-Y');
    $view = \View::make('secretaria.alumno.reporte', [
              'categorias' => $categorias,
              'alumno' => $alumno->nombres . ' '. $alumno->apellidos,
              'matricula' => $matricula,
              'fecha' => $fecha,
              'total' => $total,
            ])->render();
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream($archivo);
  }
  /**
   * Muestra la vista para agregar deudas anteriores de un alumno
   */
  public function agregarDeudasAnteriores()
  {
    return view('secretaria.alumno.deuda.anteriores');
  }
  /**
   * Crear deudas anteriores para un alumno
   */
  public function crearDeudasAnteriores(Request $request)
  {
    // Variables iniciales
    $resultado = 'true';
    $mensaje = [];
    try {
    // Recuperar parámetros enviados
    $nro_documento = $request->input('nro_documento');
    $pensiones = $request->input('pensiones');
    // Crear deuda de pensiones
    foreach ($pensiones as $pension) {
      $id_matricula = '';
      if ($pension['tipo'] == 'matricula') {
      $id_matricula = $pension['id'];
      } else {
      $id_matricula = $pension['id_matricula'];
      }
      Deuda_Ingreso::create([
      'saldo' => $pension['monto'],
      'id_categoria' => $pension['id'],
      'id_alumno' => $nro_documento,
      'id_matricula' => $id_matricula,
      ]);
    }
    } catch (\Exception $e) {
    $resultado = 'false';
    $mensaje['titulo'] = 'Error';
    $mensaje['contenido'] = $e->getMessage();
    }
    // Retornar respuesta
    $respuesta = array(
    'resultado' => $resultado,
    'mensaje' => $mensaje,
    );
    return $respuesta;
  }
  /**
   * Recuperar datos de alumno (administrador)
   */
  public function recuperarAlumno($nro_documento)
  {
    $respuesta = [];
    $alumno = Alumno::recuperarAlumno($nro_documento);
    if ($alumno) {
    $esta_autorizado = Permiso::where('id_usuario', Auth::user()->id)
                              ->where('id_institucion', $alumno->id_institucion)
                              ->count() > 0;
    if ($esta_autorizado) {
      $respuesta['resultado'] = 'true';
      $respuesta['alumno'] = $alumno;
    } else {
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = 'Usuario no autorizado para administrar este alumno.';
    }
    } else {
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = 'Código de alumno no registrado.';
    }
    return $respuesta;
  }
  /**
   * Recuperar datos de alumno (administrador)
   */
  public function recuperarDatosAlumno($nro_documento)
  {
    $respuesta = [];
    $alumno = Alumno::recuperarDatosAlumno($nro_documento);
    if ($alumno) {
      $respuesta['resultado'] = 'true';
      $respuesta['alumno'] = $alumno;
    } else {
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = 'Código de alumno no registrado.';
    }
    return $respuesta;
  }
  /*** Eliminar deuda del alumno ***/
  public function modificarDeudasAlumno(Request $request)
  {
    $respuesta = [];
    try {
      $nro_documento = $request['nro_documento'];
      $resolucion = $request['resolucion'];
      $deudas = $request['deudas'];
      // Recuperar autorización
      $autorizacion = Autorizacion::recuperar($nro_documento, $resolucion);
      if ($autorizacion) {
        $hoy = date('Y-m-d');
        if ($autorizacion->estado == '0' && $autorizacion->fecha_limite >= $hoy) {
          $deudas_anuladas = [];
          DB::beginTransaction();
          foreach ($deudas as $deuda) {
            $anular = filter_var(array_key_exists('anulada', $deuda) ? $deuda['anulada'] : 'false', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE );
            if ($anular) {
              array_push($deudas_anuladas, $deuda['id']);
            } else {
              $deuda_aux = Deuda_Ingreso::find($deuda['id']);
              $deuda_aux->descuento += $deuda['descuento'];
              $deuda_aux->estado_descuento = '1';
              $deuda_aux->save();
            }
          }
          // Anular deudas seleccionadas
          Deuda_Ingreso::whereIn('id', $deudas_anuladas)
                       ->update(['estado_anulada' => true]);
          // Cambiar estado de la Autorización
          $autorizacion->estado = '1';
          $autorizacion->save();
          DB::commit();
          $respuesta['resultado'] = 'true';
        } else {
          $respuesta['resultado'] = 'false';
          $respuesta['mensaje'] = 'Resolución vencida o ya fue utilizada.';
        }
       } else {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = 'Resolución no válida.';
       }
    } catch (\Exception $e) {
      DB::rollback();
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
  }
  /*
   * Devolver los datos del alumno conjuntamente con sus deudas
   */
  public function recuperarDeudasAlumno($nro_documento, $tipo = '')
  {
    $respuesta = [];
    try {
      $alumno = Alumno::recuperarAlumno($nro_documento);
      if ($alumno) {
        $respuesta['alumno'] = $alumno;
        $respuesta['deudas'] = Deuda_Ingreso::deudasDeAlumnoPorUsuario($nro_documento, $tipo);
        $respuesta['resultado'] = 'true';
      } else {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = 'Código de alumno no registrado.';
      }
    } catch (\Exception $e) {
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
  }
  /*
   * Cancelar (eliminar) Deudas de alumno
   */
  public function cancelarDeudasAlumno(Request $request)
  {
    $respuesta = [];
    try {
      // Recuperar las deuda enviadas
      $deudas = $request->input('deudas');
      // Extraer solo los ids de las deudas enviadas
      $ids = array_map(function($deuda) { return $deuda['id']; }, $deudas);
      // Eliminar las deudas
      DB::beginTransaction();
      Deuda_Ingreso::whereIn('id', $ids)
                   ->delete();
      DB::commit();
      $respuesta['resultado'] = 'true';
    } catch (\Exception $e) {
      DB::rollback();
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
  }
}
