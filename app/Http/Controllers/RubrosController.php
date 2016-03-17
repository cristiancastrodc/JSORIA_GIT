<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\RubroCreateRequest;
use JSoria\Http\Controllers\Controller;

use JSoria\Rubro;
use Redirect;
use Session;

class RubrosController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('tesorera');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rubros = Rubro::All();
        return view('tesorera.rubro.index', compact('rubros'));
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

    public function crearconajax(Request $request)
    {
        $nombre = $request['nombre'];
        Rubro::create([
            'nombre' => $nombre
        ]);
        return response()->json(['mensaje' => 'Rubro creado']);
    }
}
