<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\CierreCicloCreateRequest;
use JSoria\Http\Controllers\Controller;

use JSoria\Alumno;
use JSoria\InstitucionDetalle;

use Auth;
use JSoria\Permiso;
use Session;
use Redirect;

class CicloController extends Controller
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
        $id_usuario = Auth::user()->id;

        $permisos = Permiso::join('institucion', 'permisos.id_institucion', '=', 'institucion.id')
                           ->where('permisos.id_usuario', '=', $id_usuario)
                           ->select('institucion.id', 'institucion.nombre')->get();
    
        return view('secretaria.ciclo.index', compact('permisos'));
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
    public function store(CierreCicloCreateRequest $request)
    {
        $id_institucion = $request['id_institucion'];
        $detalles_institucion = InstitucionDetalle::divisiones_institucion($id_institucion);
        foreach ($detalles_institucion as $detalle ) {
            $id_detalle_institucion = $detalle->id;

            //$Alumnos=Alumno::where('id_detalle_institucion', '=', $id_detalle_institucion)->update(['estado'=>0]);
            $Alumnos=Alumno::join('grado', 'alumno.id_grado', '=', 'grado.id' )
           ->where('grado.id_detalle','=', $id_detalle_institucion)
           ->update(['estado'=>0]);
        }
        Session::flash('message','Se cerro el ciclo.');
        return Redirect::to('/secretaria/ciclo/cerrar');
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
