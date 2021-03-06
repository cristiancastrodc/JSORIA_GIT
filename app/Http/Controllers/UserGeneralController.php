<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use Auth;
use JSoria\User;

class UserGeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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

    /*** Mostrar vista para Actualizar perfil de Usuario ***/
    public function actualizarPerfil()
    {
        $usuario = User::find(Auth::user()->id);
        return view('general.perfil', compact('usuario'));
    }

    /*** Guardar perfil de Usuario ***/
    public function guardarPerfil(Request $request)
    {
        if ($request->ajax()) {
            $mensaje = '';
            $tipo = '';

            $usuario = User::find(Auth::user()->id);
            if(\Hash::check($request->old_pass , $usuario->password)) {
                $usuario->password = $request->new_pass;
                $usuario->save();
                $mensaje = 'Datos de usuario actualizados correctamente.';
                $tipo = 'exito';
            } else{
                $mensaje = 'Error en la contraseña. Vuelva a intentar.';
                $tipo = 'error';
            }
            return response()->json(['mensaje' => $mensaje, 'tipo' => $tipo]);
        }
    }
}
