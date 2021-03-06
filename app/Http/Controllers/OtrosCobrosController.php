<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\OtrosCobrosCreateRequest;
use JSoria\Http\Requests\OtrosCobrosUpdateRequest;
use JSoria\Http\Controllers\Controller;

use JSoria\Categoria;
use JSoria\InstitucionDetalle;
use Redirect;
use Session;

class OtrosCobrosController extends Controller
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
        /*** Mostrar lista de usuarios ***/
        $categories = Categoria::All();
        return view('admin.cobro.otro', compact('categories'));
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
    public function store(OtrosCobrosCreateRequest $request)
    {
        $id = InstitucionDetalle::where('id_institucion', '=', $request['id_institucion'])->where('nombre_division', '=', 'Todo')->first()->id;
        $otracuenta = $request['exterior'];
        $habilitado = $request['habilitado'];
        if ($otracuenta) {
            $destino = '1';
        } else {
            $destino = '0';
        }
        if ($habilitado) {
            $estado = '1';
        } else {
            $estado = '0';
        }
        Categoria::create([
            'id_detalle_institucion' => $id,
            'nombre' => $request->nombre,
            'monto' => $request->monto,
            'tipo' => 'multiple',
            'destino' => $destino,
            'estado' => $estado,
            ]);

        Session::flash('message', 'Otros Cobros fue creado correctamente.');
        return Redirect::to('/admin/cobros/otros');
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
    public function update(OtrosCobrosUpdateRequest $request, $id)
    {
        if ($request->ajax()) {
            $nombre = $request['nombre'];
            $monto = $request['monto'];
            $estado = $request['estado'] == "true" ? 1 : 0;

            Categoria::find($id)->update(['nombre' => $nombre, 'monto' => $monto, 'estado' => $estado]);

            return response()->json(['mensaje' => 'Actualizado']);
        } else {
            return response()->json(['mensaje' => 'Request not AJAX.']);
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

    /*
    * Listar cobros
    */
    public function listaCobros(Request $request, $id_institucion)
    {
        if ($request->ajax()) {
            $otros_cobros = Categoria::otrosCobrosInstitucion($id_institucion);
            return response()->json($otros_cobros);
        }
    }
}
