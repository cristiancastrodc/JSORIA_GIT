<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\RubroCreateRequest;
use JSoria\Http\Requests\RubroUpdateRequest;
use JSoria\Http\Controllers\Controller;

use JSoria\Rubro;
use JSoria\Usuario_Modulos;
use JSoria\DetalleEgreso;
use Redirect;
use Session;

class RubrosController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rubros = Rubro::All();
        return 'hola';
        //return view('tesorera.rubro.index', compact('rubros'));
    }

    public function fixed_index()
    {
        $rubros = Rubro::All();
        $modulos = Usuario_Modulos::modulosDeUsuario();

        return view('tesorera.rubro.index', compact('rubros', 'modulos'));
    }

    public function fixed_guardar(RubroCreateRequest $request)
    {
        if ($request->ajax()) {
            $nombre = $request->nombre;
            Rubro::create([
                'nombre' => $nombre
            ]);
            return response()->json(['mensaje' => 'Rubro creado exitosamente.']);
        }
        /*
        $nombre = $request['nombre'];
        Rubro::create([
            'nombre' => $nombre
        ]);

        Session::flash('message','Se creó el rubro.');
        return Redirect::to('/tesorera/rubros');
        */
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
    public function store(RubroCreateRequest $request)
    {
        $nombre = $request['nombre'];
        Rubro::create([
            'nombre' => $nombre
        ]);

        Session::flash('message','Se creó el rubro.');
        return Redirect::to('/tesorera/rubros');
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
    public function update(RubroUpdateRequest $request, $id)
    {
        $rubro = Rubro::find($id);
        $rubro->nombre = $request['nombre'];
        $rubro->save();

        return response()->json(['mensaje' => 'Rubro editado correctamente.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = DetalleEgreso::where('id_rubro', $id)->get();
            if ($data->isEmpty()) {
                Rubro::destroy($id);
                return response()->json(['mensaje' => 'Rubro eliminado correctamente.', 'tipo' => 'exito']);
            } else {
                return response()->json(['mensaje' => 'No se puede eliminar el rubro. Existen egresos asociados.', 'tipo' => 'error']);
            }
            //return response()->json(['data' => $data->isEmpty()]);
        }
    }

    public function crearconajax(Request $request)
    {
        $nombre = $request['nombre'];
        Rubro::create([
            'nombre' => $nombre
        ]);
        return response()->json(['mensaje' => 'Rubro creado']);
    }

    public function rubrosInstitucion(Request $request)
    {
        if ($request->ajax()) {
            $rubros = Rubro::rubro_instituciones();
            return response()->json($rubros);
        }
    }

    /*** Listar los rubros ***/
    public function listaRubros(Request $request)
    {
        if ($request->ajax()) {
            $rubros = Rubro::all();
            return response()->json($rubros);
        }
    }

    /**
     * Retorna la vista de administración de los rubros
     */
    public function administrarRubros()
    {
        $rubros = Rubro::all();
        $modulos = Usuario_Modulos::modulosDeUsuario();

        return view('tesorera.rubro.administrar', ['rubros' => $rubros, 'modulos' => $modulos]);
    }

    /**
     * Almacena un nuevo rubro
     */
    public function crearRubro(Request $request)
    {
        Rubro::create([
            'nombre' => $request['rubro']
            ]);
        Session::flash('message-class', 'success');
        Session::flash('message','Rubro creado.');
        return Redirect::back();
    }

    /**
     * Actualiza un rubro
     */
    public function actualizarRubro(Request $request, $id_rubro)
    {
        try {
            $rubro = Rubro::find($id_rubro);
            $rubro->nombre = $request['nombre'];
            $rubro->save();

            Session::flash('message-class', 'success');
            Session::flash('message','Rubro actualizado.');

            return response()->json(['resultado' => true, 'mensaje' => 'Rubro actualizado.']);
        } catch (Exception $e) {
            return response()->json(['resultado' => false]);
        }
    }

    /**
     * Elimina un rubro
     */
    public function eliminarRubro($id_rubro)
    {
        $detalles = DetalleEgreso::where('id_rubro', $id_rubro)->get();
        if ($detalles->isEmpty()) {
            Rubro::destroy($id_rubro);
            Session::flash('message-class', 'success');
            Session::flash('message','Rubro eliminado.');
            return Redirect::back();
        } else {
            Session::flash('message-class', 'danger');
            Session::flash('message','No se puede eliminar el rubro. Existen egresos asociados.');
            return Redirect::back();
        }
    }
}
