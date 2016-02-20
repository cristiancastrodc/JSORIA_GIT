<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Alumno;
use JSoria\Permiso;
use JSoria\Categoria;
use JSoria\Deuda_Ingreso;
use Redirect;
use Session;
use Auth;

class AlumnosController extends Controller
{
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
    public function store(Request $request)
    {
        $nro_documento = $request['nro_documento'];
        $tipo_documento = $request['tipo_documento'];

        Alumno::create([
            'tipo_documento' =>$tipo_documento,
            'nro_documento' => $nro_documento,
            'nombres' => $request['nombres'],
            'apellidos' => $request['apellidos']
            ]);

        Session::flash('message', 'Alumno creado exitosamente. Ahora, si desea puede crear su cuenta.');
        return redirect('/secretaria/alumno/matricular')->with('nro_documento', $nro_documento);
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
    public function update(Request $request, $dni)
    {
        if ($request->ajax()) {
            $alumno = Alumno::find($dni);

            $id_detalle_institucion = $request['id_detalle_institucion'];

            $alumno->estado = $request['estado'];
            $alumno->id_detalle_institucion = $id_detalle_institucion;

            $alumno->save();

            /*** Agregar las deudas del alumno ***/
            $matriculas = Categoria::where('tipo', '=', 'matricula')
                                   ->where('estado', '=', 1)
                                   ->where('id_detalle_institucion', '=', $id_detalle_institucion)
                                   ->get();

            foreach ($matriculas as $matricula) {
                Deuda_Ingreso::create([
                    'saldo' => $matricula->monto,
                    'id_categoria' => $matricula->id,
                    'id_alumno' => $dni,
                ]);
            }

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
                    'id_alumno' => $dni,
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
        if ($request->ajax()) {
            $alumno = Alumno::datos_alumno($dni);
            return response()->json($alumno);
        }
    }
}
