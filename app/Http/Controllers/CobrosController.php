<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Config;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;
use JSoria\Alumno;
use JSoria\Categoria;
use JSoria\Comprobante;
use JSoria\Deuda_Ingreso;
use JSoria\Institucion;
use JSoria\InstitucionDetalle;
use JSoria\Permiso;
use JSoria\UsuarioImpresora;
use JSoria\Http\Controllers\HerramientasController;


class CobrosController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('Cajera');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $categorias = Categoria::listaOtrosCobrosCajera();
      $tipo_impresora = UsuarioImpresora::find(Auth::user()->id)->tipo_impresora;
      return view('cajera.cobros.index', compact('categorias', 'tipo_impresora'));
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
    * Buscar Deudas de Alumno o Pago único
    **/
    public function buscarDeudas(Request $request, $nro_documento)
    {
        if ($request->ajax()) {
            $alumno = Alumno::find($nro_documento);

            if ($alumno) {
              if ($alumno->estado == '1') {
                $alumno = Alumno::join('grado','alumno.id_grado','=','grado.id')
                          ->where('alumno.nro_documento','=', $nro_documento)
                          ->select('alumno.nro_documento', 'alumno.nombres', 'alumno.apellidos', 'grado.id_detalle')
                          ->first();
                $id_institucion = InstitucionDetalle::find($alumno->id_detalle)->id_institucion;

                $permisos = Permiso::where('id_usuario', Auth::user()->id)
                                   ->where('id_institucion', $id_institucion)
                                   ->get();

                if (!$permisos->isEmpty()) {
                  $institucion =  Institucion::find($id_institucion);
                  $detalle_institucion = InstitucionDetalle::where('id_institucion', '=', $id_institucion)
                                         ->where('nombre_division', '=', 'Todo')
                                         ->first()->id;
                  $categorias = Categoria::where('tipo', '=', 'sin_factor')
                                         ->where('estado', '=', 1)
                                         ->where('id_detalle_institucion','=', $detalle_institucion)
                                         ->get();

                  $deudas = Deuda_Ingreso::join('categoria','deuda_ingreso.id_categoria','=','categoria.id')
                            ->where('deuda_ingreso.id_alumno','=', $nro_documento)
                            ->where('deuda_ingreso.estado_pago','=', 0)
                            ->select('deuda_ingreso.id','categoria.nombre','deuda_ingreso.saldo', 'deuda_ingreso.descuento', 'categoria.tipo', 'categoria.fecha_fin', 'deuda_ingreso.estado_descuento', 'deuda_ingreso.estado_fraccionam', 'categoria.destino')
                            ->get();

                  $hoy = date('Y/m/d');
                  foreach ($deudas as $deuda) {
                      if ($deuda->tipo == "pension" && $deuda->estado_descuento == "0" && $deuda->estado_fraccionam == "0") {
                          $descuento = 0;
                          $tiempo = strtotime($deuda->fecha_fin);
                          $fecha_fin = date('Y/m/d', $tiempo);
                          $descuento = $id_institucion == "3" && $hoy <= $fecha_fin ? floatval($deuda->saldo) * 0.11 : $descuento;
                          $descuento = $id_institucion == "4" && $hoy <= $fecha_fin ? floatval($deuda->saldo) * 0.15 : $descuento;
                          $deuda->descuento = $descuento;
                          $deuda->save();
                      }
                  }

                  $response = array($alumno, $institucion, $deudas, $categorias, 'tipo' => 'alumno_existe');

                  return $response;
                } else {
                  return response()->json(['tipo' => 'warning', 'mensaje' => 'Usuario no autorizado a realizar este cobro.']);
                }
              } else {
                return response()->json(['tipo' => 'warning', 'mensaje' => 'El alumno no está matriculado.']);
              }
            } else {
                $deuda = Deuda_Ingreso::where('id', '=', $nro_documento)->first();

                if ($deuda) {
                  if ($deuda->cliente_extr != null && $deuda->descripcion_extr != null) {
                    if ($deuda->estado_pago == '0') {
                      return response()->json(['mensaje' => 'Existe deuda extraordinaria', 'deuda' => $deuda, 'tipo' => 'hay_deuda_extr']);
                    } else {
                      return response()->json(['mensaje' => 'La deuda ya fue cancelada', 'tipo' => 'warning']);
                    }
                  } else {
                      return response()->json(['mensaje' => 'No se encuentra alumno ni codigo correspondiente al dato ingresado.', 'tipo' => 'warning']);
                  }
                } else {
                  return response()->json(['mensaje' => 'No se encuentra alumno ni codigo correspondiente al dato ingresado.', 'tipo' => 'warning']);
                }
            }
        } else {
            return response()->json(['mensaje' => 'Esta petición sólo se puede acceder desde AJAX.']);
        }
    }

    public function guardarCobro(Request $request)
    {
        $mensaje = '';
        if ($request->ajax()) {
            $deudas = $request['id_pagos'];
            $deudas = array_filter(explode(',', $deudas));

            $pagos = array();
            $monto_total = 0;
            $fecha_hora_ingresos = date("Y-m-d H:i:s");

            foreach ($deudas as $deuda) {
                $pago = Deuda_Ingreso::find($deuda);
                $pago->estado_pago = 1;
                $pago->fecha_hora_ingreso = $fecha_hora_ingresos;
                $pago->id_cajera = Auth::user()->id;
                $pago->tipo_comprobante = $request['tipo_comprobante'];
                $pago->serie_comprobante = $request['serie_comprobante'];
                $pago->numero_comprobante = $request['numero_comprobante'];
                $pago->save();

                $categoria = Categoria::find($pago->id_categoria);
                $monto = floatval($pago->saldo) - floatval($pago->descuento);
                $monto_total += $monto;
                $concepto = array($categoria->nombre, $monto);
                array_push($pagos, $concepto);
            }

            $compras = $request['id_compras'];
            $compras = array_filter(explode(',', $compras));
            $nro_compras = intval(count($compras) / 2);

            $nro_documento = $request['nro_documento'];
            for ($i = 0; $i < $nro_compras; $i++) {
                $i1 = $i + 1;
                Deuda_Ingreso::create([
                    'saldo' => $compras[$i1],
                    'estado_pago' => 1,
                    'id_categoria' => $compras[$i],
                    'id_alumno' => $nro_documento,
                    'id_cajera' => Auth::user()->id,
                    'fecha_hora_ingreso' => $fecha_hora_ingresos,
                    'tipo_comprobante' => $request['tipo_comprobante'],
                    'serie_comprobante' => $request['serie_comprobante'],
                    'numero_comprobante' => $request['numero_comprobante'],
                ]);

                $categoria = Categoria::find($compras[$i]);
                $monto = $compras[$i1];
                $monto_total += $monto;
                $concepto = array($categoria->nombre, $monto);
                array_push($pagos, $concepto);
            }

            /*
             * TODO: Actualizar datos del correlativo
             * Enviar serie y numero a los metodos de imprimir, quitar el aumento del correlativo interior
            */

            $alumno = Alumno::find($nro_documento);
            $nombre_completo = strtoupper($alumno->nombres . " " . $alumno->apellidos);

            $mensaje = 'Pagos de alumno correctamente actualizados.';

            $usuario_impresora = UsuarioImpresora::find(Auth::user()->id);
            if ($usuario_impresora->tipo_impresora == 'matricial') {
                if ($request['tipo'] == 'comprobante' || $request['tipo'] == 'boleta') {
                    HerramientasController::imprimirBoletaCompMatricial($nro_documento, $nombre_completo, $pagos, $monto_total, $usuario_impresora->nombre_impresora);
                } elseif ($request['tipo'] == 'factura') {
                  if (Config::get('config.usar_facturas')) {
                    HerramientasController::imprimirFacturaMatricial($nro_documento, $nombre_completo, $pagos, $monto_total, $request['ruc_cliente'], $request['razon_social'], $request['direccion'], $usuario_impresora->nombre_impresora);
                  } else {
                    $mensaje = 'Pagos de alumno actualizados. Puede girar la factura manualmente.';
                  }
                };
            } elseif ($usuario_impresora->tipo_impresora == 'ticketera') {
                if ($request['tipo'] == 'comprobante') {
                    HerramientasController::imprimirComprobanteTicketera($nro_documento, $nombre_completo, $pagos, $monto_total, $usuario_impresora->nombre_impresora);
                } else {
                    $mensaje = 'Pagos de alumno actualizados. Puede girar la boleta/factura manualmente.';
                }
            }

            return response()->json(['mensaje' => $mensaje]);
        }
    }

    public function guardarCobroExtraordinario(Request $request)
    {
        if ($request->ajax()) {
          $id_deuda = $request->id_deuda_extr;

          $deuda = Deuda_Ingreso::find($id_deuda);
          $deuda->estado_pago = 1;
          $deuda->fecha_hora_ingreso = date('Y-m-d H:i:s');
          $deuda->id_cajera = Auth::user()->id;
          $deuda->save();

          $mensaje = 'Cobro realizado exitosamente.';
          $usuario_impresora = UsuarioImpresora::find(Auth::user()->id);
          if ($usuario_impresora->tipo_impresora == 'matricial') {
            if ($request['tipo'] == 'comprobante' || $request['tipo'] == 'boleta') {
              HerramientasController::imprimirBoletaCompMatricialExtr($deuda->cliente_extr, $deuda->descripcion_extr, $deuda->saldo, $usuario_impresora->nombre_impresora);
            } elseif ($request['tipo'] == 'factura') {
              if (Config::get('config.usar_facturas')) {
                HerramientasController::imprimirFacturaMatricialExtr($deuda->cliente_extr, $deuda->descripcion_extr, $deuda->saldo, $request['ruc_cliente'], $request['razon_social'], $request['direccion'], $usuario_impresora->nombre_impresora);
              } else {
                $mensaje = 'Cobro realizado. Puede girar la factura manualmente.';
              }
            };
          } elseif ($usuario_impresora->tipo_impresora == 'ticketera') {
            if ($request['tipo'] == 'comprobante') {
              $institucion = Deuda_Ingreso::join('categoria', 'deuda_ingreso.id_categoria', '=', 'categoria.id')
                                          ->join('detalle_institucion', 'categoria.id_detalle_institucion', '=', 'detalle_institucion.id')
                                          ->join('institucion', 'detalle_institucion.id_institucion', '=', 'institucion.id')
                                          ->where('deuda_ingreso.id', $id_deuda)
                                          ->select('institucion.id_razon_social','institucion.razon_social', 'institucion.ruc')
                                          ->first();
              //$id_razon_social = $institucion->id_razon_social;
              HerramientasController::imprimirComprobanteTicketeraExtr($deuda->cliente_extr, $deuda->descripcion_extr, $deuda->saldo, $institucion, $usuario_impresora->nombre_impresora);
            } else {
              $mensaje = 'Cobro realizado. Puede girar la boleta/factura manualmente.';
            }
          }
          // return response()->json(['mensaje' => 'Cobro realizado exitosamente.']);
          return response()->json(['mensaje' => $mensaje]);
        }
    }

    public function guardarCobroMultiple(Request $request)
    {
      if ($request->ajax()) {
        $tipo = $request->tipo;
        $mensaje = '';
        $id_categoria = $request->id_categoria;
        $dni = $request->dni;
        $nombre = $request->nombre;
        $ruc = $request->ruc_cliente;
        $razon_social = $request->razon_social;
        $direccion = $request->direccion;

        $cliente_extr = '';
        $descripcion_extr = '';
        if ($tipo == 'boleta' || $tipo == 'comprobante') {
          $cliente_extr = $dni;
          $descripcion_extr = $nombre;
        } else {
          $cliente_extr = $ruc;
          $descripcion_extr = $razon_social . ' - ' . $direccion;
        }

        $categoria = Categoria::find($id_categoria);
        Deuda_Ingreso::create([
          'saldo' => $categoria->monto,
          'estado_pago' => 1,
          'cliente_extr' => $cliente_extr,
          'descripcion_extr' => $descripcion_extr,
          'fecha_hora_ingreso' => date('Y-m-d H:i:s'),
          'id_categoria' => $id_categoria,
          'id_cajera' => Auth::user()->id
        ]);

        $mensaje = 'Venta realizada exitosamente.';

        $usuario_impresora = UsuarioImpresora::find(Auth::user()->id);
        if ($usuario_impresora->tipo_impresora == 'matricial') {
          if ($request['tipo'] == 'comprobante' || $request['tipo'] == 'boleta') {
              HerramientasController::imprimirBoletaCompMatricialMultiple($dni, $nombre, $categoria, $usuario_impresora->nombre_impresora);
          } elseif ($request['tipo'] == 'factura') {
            if (Config::get('config.usar_facturas')) {
              HerramientasController::imprimirFacturaMatricialMultiple($ruc, $razon_social, $direccion, $categoria, $usuario_impresora->nombre_impresora);
            } else {
              $mensaje = 'Venta exitosa. Puede girar la factura manualmente.';
            }
          };
        } elseif ($usuario_impresora->tipo_impresora == 'ticketera') {
          if ($request['tipo'] == 'comprobante') {
              HerramientasController::imprimirComprobanteTicketeraMultiple($dni, $nombre, $categoria, $usuario_impresora->nombre_impresora);
          } else {
              $mensaje = 'Venta exitosa. Puede girar la boleta/factura manualmente.';
          }
        }

        return response()->json(['mensaje' => $mensaje]);
      }
    }

    /**
    * Buscar Deudas de Alumno o Pago único
    **/
    public function buscarComprobante($id_institucion, $tipo_comprobante)
    {
      $tipo_impresora = UsuarioImpresora::find(Auth::user()->id)->tipo_impresora;
      $datos_comprobante = Comprobante::datosComprobante($tipo_comprobante, $tipo_impresora, $id_institucion);
      $numero = str_pad(intval($datos_comprobante->numero_comprobante) + 1, $datos_comprobante->pad_izquierda, '0', STR_PAD_LEFT);

      return response()->json([
        'serie' => $datos_comprobante->serie,
        'numero' => $numero
        ]);
    }
}
