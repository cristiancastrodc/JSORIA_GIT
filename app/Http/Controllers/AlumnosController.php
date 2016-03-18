<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\AlumnoCreateRequest;
use JSoria\Http\Requests\AlumnoUpdateRequest;
use JSoria\Http\Controllers\Controller;

use JSoria\Alumno;
use JSoria\Permiso;
use JSoria\Categoria;
use JSoria\Deuda_Ingreso;
use JSoria\Grado;
use JSoria\InstitucionDetalle;
use Redirect;
use Session;
use Auth;

class AlumnosController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('Secretaria');
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

            $estado = Alumno::where('nro_documento','=',$documento)->first();
            $alumno = Alumno::join('grado','alumno.id_grado','=','grado.id')
                                ->where('alumno.nro_documento','=',$documento)
                                ->select('alumno.estado', 'alumno.nombres', 'alumno.apellidos', 'grado.id_detalle', 'alumno.nro_documento')
                                ->first();


            if ($estado) {
                if ($estado->estado == 1) {
                $id_institucion = InstitucionDetalle::find($alumno->id_detalle)->id_institucion;

                $detalle_institucion = InstitucionDetalle::where('id_institucion', '=', $id_institucion)
                                                         ->where('nombre_division', '=', 'Todo')
                                                         ->first()->id;
                $categorias = Categoria::where('tipo', '=', 'con_factor')
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
                                   ->select('deuda_ingreso.id','categoria.nombre','deuda_ingreso.saldo')
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
                                   ->select('deuda_ingreso.id','categoria.nombre','deuda_ingreso.saldo')
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
            $deudas = $request->deudas;

            foreach ($deudas as $deuda) {
                $id_categoria = $deuda['id_categoria'];
                $monto = Categoria::find($id_categoria)->monto;
                $saldo = floatval($monto) * floatval($deuda['factor']);

                Deuda_Ingreso::create([
                    'saldo' => $saldo,
                    'id_categoria' => $id_categoria,
                    'id_alumno' => $nro_documento
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
}
