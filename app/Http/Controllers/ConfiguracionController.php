<?php

namespace JSoria\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;
use JSoria\Balance;
use JSoria\Configuracion;
use JSoria\Comprobante;
use Redirect;
use Session;

class ConfiguracionController extends Controller
{

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
      $respuesta = [];
      $respuesta['resultado'] = 'true';
      try {
        $tipo_comprobante = $request->input('tipo_comprobante');
        $serie_comprobante = $request->input('serie_comprobante');
        $numero_comprobante = $request->input('numero_comprobante');
        $pad_izquierda = strlen($numero_comprobante);
        $id_institucion = $request->input('id_institucion');
        // Iniciar transacción de BD
        DB::beginTransaction();
        // Crear el comprobante
        Comprobante::create([
            'tipo' => $tipo_comprobante,
            'serie' => $serie_comprobante,
            'numero_comprobante' => $numero_comprobante,
            'pad_izquierda' => $pad_izquierda,
            'id_institucion' => $id_institucion,
            ]);
        // Si no hubo errores, finalizar la transacción
        DB::commit();
      } catch (\Exception $e) {
        // Abortar la transacción
        DB::rollBack();
        $respuesta['resultado'] = false;
        $respuesta['mensaje'] = $e->getMessage();
      }
      return $respuesta;
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
      // Recuperar valores
      $dia_limite_instituto = Configuracion::valor('dia_limite_descuento', 1);
      $porcentaje_instituto = Configuracion::valor('porcentaje_descuento', 0);
      $dia_limite_ulp = Configuracion::valor('dia_limite_descuento_ulp', 1);
      $porcentaje_ulp = Configuracion::valor('porcentaje_descuento_ulp', 0);
      // Enviar a procesar en la vista
      return view('admin.configuracion.index', [
        'dia_limite_instituto' => $dia_limite_instituto,
        'porcentaje_instituto' => $porcentaje_instituto,
        'dia_limite_ulp' => $dia_limite_ulp,
        'porcentaje_ulp' => $porcentaje_ulp,
        ]);
    }
    /**
     * Almacena la configuración del sistema
     */
    public function guardarConfiguracionEmpresa(Request $request)
    {
      Configuracion::actualizar('dia_limite_descuento', $request->dia_limite_instituto);
      Configuracion::actualizar('porcentaje_descuento', $request->porcentaje_instituto);

      Configuracion::actualizar('dia_limite_descuento_ulp', $request->dia_limite_ulp);
      Configuracion::actualizar('porcentaje_descuento_ulp', $request->porcentaje_ulp);

      return redirect()->back()->with('message', 'Configuracion actualizada.')->withInput();
    }
    /**
     * Retorna la lista de comprobantes
     */
    public function listarComprobantes()
    {
      return Comprobante::listarComprobantes();
    }
    /**
     * Actualiza los datos de un comprobante.
     */
    public function actualizarComprobante(Request $request, $id)
    {
      $respuesta = [];
      try {
        $serie = $request->input('serie_comprobante');
        $numero = $request->input('numero_comprobante');
        $pad_izquierda = strlen($numero);
        $comprobante = Comprobante::find($id);
        if ($comprobante) {
          $comprobante->serie = $serie;
          $comprobante->numero_comprobante = $numero;
          $comprobante->pad_izquierda = $pad_izquierda;
          $comprobante->save();
          $respuesta['resultado'] = 'true';
        } else {
          $respuesta['resultado'] = 'false';
          $respuesta['mensaje'] = 'Comprobante no existe.';
        }
      } catch (\Exception $e) {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = $e->getMessage();
      }
      return $respuesta;
    }
    /**
     * Elimina un comprobante.
     */
    public function eliminarComprobante($id)
    {
      $respuesta = [];
      try {
        $comprobante = Comprobante::find($id);
        if ($comprobante) {
          $comprobante->delete();
          $respuesta['resultado'] = 'true';
        } else {
          $respuesta['mensaje'] = 'Comprobante no existe.';
          $respuesta['resultado'] = 'false';
        }
      } catch (\Exception $e) {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = $e->getMessage();
      }
      return $respuesta;
    }
}
