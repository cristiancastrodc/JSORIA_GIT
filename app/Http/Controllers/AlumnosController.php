<?php

namespace JSoria\Http\Controllers;

use Auth;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('secretaria.alumno.create');
        //return view('secretaria.alumno.create');
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
            $nro_documento = $request['nro_documento'];
            $tipo_documento = $request['tipo_documento'];

            Alumno::create([
                'tipo_documento' =>$tipo_documento,
                'nro_documento' => $nro_documento,
                'nombres' => $request['nombres'],
                'apellidos' => $request['apellidos'],
                ]);

            Session::flash('message', 'Alumno creado exitosamente. Ahora, si desea puede crear su cuenta.');
            return redirect('/secretaria/alumno/matricular')->with('nro_documento', $nro_documento);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('message', 'El número de documento ingresado ya existe.');
            return redirect('/secretaria/alumnos/create');
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
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
            /*
            $matriculas = Categoria::where('tipo', '=', 'matricula')
                                   ->where('estado', '=', 1)
                                   ->where('id_detalle_institucion', '=', $id_detalle_institucion)
                                   ->get();

            foreach ($matriculas as $matricula) {
                Deuda_Ingreso::create([
                    'saldo' => $matricula->monto,
                    'id_categoria' => $matricula->id,
                    'id_alumno' => $nro_documento,
                ]);
            }
            */

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
    * Matricular a un alumno
    **/
    public function matricular()
    {
        $id_usuario = Auth::user()->id;

        $permisos = Permiso::join('institucion', 'permisos.id_institucion', '=', 'institucion.id')
                           ->where('permisos.id_usuario', '=', $id_usuario)
                           ->select('institucion.id', 'institucion.nombre')->get();

        return view('secretaria.alumno.matricular', compact('permisos'));
    }
    /**
    * Agregar deudas
    **/
    public function agregarDeuda()
    {
        return view('secretaria.alumno.deuda.agregar');

        //return view('secretaria.alumno.deuda.agregar');
    }
    /**
    * Modificar deudas
    **/
    public function deudas()
    {
        return view('secretaria.alumno.deuda.index');

        //return view('secretaria.alumno.deuda.index');
    }
    /**
    * Cancelar deudas de actividad
    **/
    public function cancelarDeudaActividad()
    {
        return view('secretaria.alumno.deuda.cancelar');

        //return view('secretaria.alumno.deuda.cancelar');
    }
    /**
    * Autorizar amortización
    **/
    public function amortizacion()
    {
        return view('secretaria.alumno.deuda.amortizacion');

        //return view('secretaria.alumno.deuda.amortizacion');
    }

    public function datosAlumno(Request $request, $dni)
    {
        //return response()->json(['mensaje' => 'ok']);
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
        //$estado = Alumno::where('nro_documento','=',$documento)->first();
        $alumno = Alumno::join('grado','alumno.id_grado','=','grado.id')
                        ->where('alumno.nro_documento','=',$documento)
                        ->select('alumno.estado', 'alumno.nombres', 'alumno.apellidos', 'grado.id_detalle', 'alumno.nro_documento')
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

    public function listaDeudasAlumno(Request $request, $documento)
    {
        if ($request->ajax()) {
            $deudas = Deuda_Ingreso::join('categoria','deuda_ingreso.id_categoria','=','categoria.id')
                                   ->where('deuda_ingreso.id_alumno','=',$documento)
                                   ->where('deuda_ingreso.estado_pago','=',0)
                                   ->where('deuda_ingreso.estado_descuento','=',0)
                                   ->select('deuda_ingreso.id','categoria.nombre','deuda_ingreso.saldo')
                                   ->get();

            $alumno = Alumno::where('alumno.nro_documento','=',$documento)
                            ->select('nombres', 'apellidos','nro_documento')
                            ->first();

            if ($alumno) {
                $response = array($alumno, $deudas);
                return response()->json($response);
            } else {
                return response()->json([
                    'mensaje' => 'El alumno no existe.'
                ]);
            }
        }
    }

    public function listaDeudasActividadesAlumno(Request $request, $documento)
    {
        if ($request->ajax()) {

            $alumno = Alumno::where('nro_documento','=',$documento)->first();
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
      if ($request->ajax()) {
        $nro_documento = $request->nro_documento;
        $alumno = Alumno::find($nro_documento);
        $deudas = $request->deudas;

        foreach ($deudas as $deuda) {
          $id_categoria = $deuda['id_categoria'];
          $monto = Categoria::find($id_categoria)->monto;
          $saldo = floatval($monto) * floatval($deuda['factor']);

          Deuda_Ingreso::create([
              'saldo' => $saldo,
              'id_categoria' => $id_categoria,
              'id_alumno' => $nro_documento,
              'id_matricula' => $alumno->id_matricula,
          ]);
        }
        return response()->json(['mensaje' => 'Deudas de alumno creadas exitosamente.']);
      }
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

  /*** Eliminar deuda del alumno ***/
    public function EliminarDescontarDeuda(Request $request)
    {
        if ($request->ajax()) {
            $deudas = $request->deudas;
            $resolucion = $request->resolucion;
            $nro_documento = $request->nro_documento;

            $Autorizado = Autorizacion::where('id_alumno','=',$nro_documento)
                                    ->where('rd','=',$resolucion)
                                    ->first();

            if ($Autorizado) {

                if ($Autorizado->estado == 0 && $Autorizado->fecha_limite >= date('Y-m-d')) {
                    $id_autorizacion = $Autorizado->id;
                    foreach ($deudas as $deuda) {
                        $id_deuda = $deuda['id_deuda'];
                        $descuento = $deuda['monto'];
                        $operacion =$deuda['operacion'];
                        if($operacion == 'eliminar'){
                            Deuda_Ingreso::where('id','=',$id_deuda)
                                      ->delete();
                            Autorizacion::where('id','=',$id_autorizacion)
                                        ->update(['estado'=>'1']);
                        }elseif ($operacion == 'descontar') {
                            Deuda_Ingreso::where('id','=',$id_deuda)
                                      ->update(['descuento'=>$descuento,'estado_descuento'=>'1']);

                            Autorizacion::where('id','=',$id_autorizacion)
                                        ->update(['estado'=>'1']);
                        }
                    }
                    return response()->json(['mensaje' => 'Deuda del alumno procesada correctamente.', 'tipo' => 'sus']);
                }else{
                    return response()->json(['mensaje' => 'La autorizacion ya vencio o ya fue utilizada.', 'tipo' => 'error']);
                }

            } else {
                return response()->json(['mensaje' => 'No Existe ninguna autorizacion para el alumno.', 'tipo' => 'error']);
            }

        }
    }

    /*** Crear Amortizacion***/
    public function CrearAmortizacion(Request $request)
    {

        if ($request->ajax()) {

        $id=$request->id_deuda;
        $Deuda = Deuda_Ingreso::find($id);
        $nro_documento = $Deuda->id_alumno;
        $id_categoria = $Deuda->id_categoria;
        $monto = $request->monto;
        $saldo = $Deuda->saldo-$monto;


        /* Actualizar saldo del id */
            Deuda_Ingreso::where('id', '=', $id)
                        ->update(['saldo' => $saldo,'estado_fraccionam'=>'1']);

        /* Crear nueva deuda con el monto*/
            Deuda_Ingreso::create([
                    'saldo' => $monto,
                    'id_categoria' => $id_categoria,
                    'id_alumno' => $nro_documento
                ]);

        return response()->json([
            'mensaje' => 'Creado'
        ]);
            //return response()->json($request->all());
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
        'alumno' => $alumno
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

      #tesorera.reportes.balance
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
}
