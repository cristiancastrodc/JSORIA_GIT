<?php

namespace JSoria\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;
use JSoria\Balance;
use JSoria\Configuracion;
use JSoria\Comprobante;
use JSoria\UsuarioImpresora;
use Redirect;
use Session;

class ConfiguracionController extends Controller
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

    /*** Vista de Configuracion de Cajera ***/
    public function cajeraImpresora()
    {
        $tipo_impresora = UsuarioImpresora::find(Auth::user()->id)->tipo_impresora;
        $opciones = '';
        if ($tipo_impresora == 'matricial') {
            $opciones = "<option value='matricial' selected>Matricial</option>";
            $opciones .= "<option value='ticketera'>Ticketera</option>";
        } else {
            $opciones = "<option value='matricial'>Matricial</option>";
            $opciones .= "<option value='ticketera' selected>Ticketera</option>";
        }
        return view('cajera.conf.impresora', compact('opciones'));
    }

    /*** Guardar configuracion de Impresora de Cajera ***/
    public function guardarCajeraImpresora(Request $request)
    {
        if ($request->ajax()) {
            $tipo_impresora = $request->tipo_impresora;

            $configuracion = UsuarioImpresora::where('id_cajera', Auth::user()->id)
                             ->first();

            if ($tipo_impresora == 'matricial') {
                $nombre_impresora = '//localhost/Matricial';
            } else if ($tipo_impresora == 'ticketera') {
                $nombre_impresora = 'Ticketera';
            }

            if ($configuracion) {
                $configuracion->tipo_impresora = $tipo_impresora;
                $configuracion->nombre_impresora = $nombre_impresora;
                $configuracion->save();

                return response()->json(['mensaje' => 'Actualizados la configuración de impresora.']);
            } else {
                UsuarioImpresora::create([
                    'id_cajera' => Auth::user()->id,
                    'tipo_impresora' => $tipo_impresora,
                    'nombre_impresora' => $nombre_impresora
                ]);
                return response()->json(['mensaje' => 'Se creó la configuración de impresora.']);
            }
        }
    }

    /**
     * Muestra la interfaz para la definición de comprobantes
     */
    public function definirComprobantes()
    {
        return view('admin.comprobantes.series');
    }

    /**
     * Guarda los datos de un comprobante
     */
    public function guardarComprobante(Request $request)
    {
        $tipo = $request["tipo_comprobante"];
        $serie = $request["serie_comprobante"];
        $numero_comprobante = intval($request["numero_comprobante"]);
        $pad_izquierda = strlen($request["numero_comprobante"]);
        $id_institucion = $request["id_institucion"];
        Comprobante::create([
            'tipo' => $tipo,
            'serie' => $serie,
            'numero_comprobante' => $numero_comprobante,
            'pad_izquierda' => $pad_izquierda,
            'id_institucion' => $id_institucion,
            ]);
        Session::flash('message', 'Datos de comprobante correctamente creados.');
        return Redirect::to('admin/comprobante/crear');
    }

    /**
     * Registra el saldo inicial para una tesorera
     */
    public function registrarSaldoInicial(Request $request)
    {
        $date = new \DateTime();
        $date->add(\DateInterval::createFromDateString('yesterday'));
        $fecha = $date->format('Y-m-d');

        Balance::create([
            'fecha' => $fecha,
            'id_tesorera' => Auth::user()->id,
            'ingresos' => floatval($request['saldo_inicial']),
        ]);

        Session::flash('message-success', 'Saldo inicial correctamente creado. Ahora puede utilizar el sistema.');
        return Redirect::to('escritorio');
    }
    /**
     * Muestra la interfaz para realizar la configuración del sistema
     */
    public function configuracionEmpresa()
    {
      $dia_limite_descuento = Configuracion::where('variable', 'dia_limite_descuento')->first();
      $porcentaje_descuento = Configuracion::where('variable', 'porcentaje_descuento')->first();
      return view('admin.configuracion.index', [
        'dia_limite_descuento' => $dia_limite_descuento->valor,
        'porcentaje_descuento' => $porcentaje_descuento->valor,
        ]);
    }
    /**
     * Almacena la configuración del sistema
     */
    public function guardarConfiguracionEmpresa(Request $request)
    {
      $dia_limite = Configuracion::valor('dia_limite_descuento');
      $dia_limite->valor = $request->dia_limite_descuento;
      $dia_limite->save();
      $porcentaje_descuento = Configuracion::valor('porcentaje_descuento');
      $porcentaje_descuento->valor = $request->porcentaje_descuento;
      $porcentaje_descuento->save();

      return redirect()->back()->with('message', 'Configuracion actualizada.')->withInput();
    }
}
