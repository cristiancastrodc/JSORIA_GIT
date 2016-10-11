<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;
use Auth;
use JSoria\Balance;
use JSoria\Deuda_Ingreso;
use JSoria\IngresoTesorera;
use JSoria\User;
use Redirect;
use Session;

class IngresosController extends Controller
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
        $cajeras = User::getCajerasTesorera(Auth::user()->id);
        return view('tesorera.ingreso.index', compact('cajeras'));
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

    /**
     * Muestra la interfaz para registrar ingresos adicionales
     */
    public function ingresosAdicionales()
    {
        return view('tesorera.ingreso.registrar');
    }

    /**
     * Registra los ingresos adicionales de una tesorera
     */
    public function registrarIngresosAdicionales(Request $request)
    {
        $id_institucion = $request['id_institucion'];
        $monto = $request['monto'];
        $id_tesorera = Auth::user()->id;
        $fecha = date('Y-m-d');

        IngresoTesorera::create([
            'id_tesorera' => $id_tesorera,
            'id_institucion' => $id_institucion,
            'monto' => $monto,
            ]);
        /** Registrar el egreso en la tabla de Balance **/
        $balance = Balance::where('fecha', $fecha)
                          ->where('id_tesorera', $id_tesorera)
                          ->first();
        if ($balance) {
            $balance->ingresos += $monto;
            $balance->save();
        }
        else {
            $saldo = $monto;
            $balance_anterior = Balance::where('id_tesorera', $id_tesorera)
                                       ->orderBy('fecha', 'desc')
                                       ->first();
            if ($balance_anterior) {
                $saldo += $balance_anterior['ingresos'] - $balance_anterior['egresos'];
            }
            Balance::create([
                'fecha' => $fecha,
                'id_tesorera' => $id_tesorera,
                'ingresos' => $saldo,
                'egresos' => 0
            ]);
        }

        Session::flash('message', 'Ingreso registrado correctamente.');
        return Redirect::back();
    }
}
