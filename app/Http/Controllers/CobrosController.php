<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Config;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;
use JSoria\Alumno;
use JSoria\Categoria;
use JSoria\Configuracion;
use JSoria\Comprobante;
use JSoria\Deuda_Ingreso;
use JSoria\Institucion;
use JSoria\InstitucionDetalle;
use JSoria\Permiso;
use JSoria\UsuarioImpresora;
use JSoria\Http\Controllers\HerramientasController;
use NumeroALetras;
use JSoria\Usuario_Modulos;

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
      $modulos = Usuario_Modulos::modulosDeUsuario();
      return view('cajera.cobros.index', compact('categorias', 'tipo_impresora', 'modulos'));
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
                          //$deuda->save();
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
                      $id_institucion = Categoria::institucionDeCategoria($deuda->id_categoria)->id_institucion;
                      return response()->json(['mensaje' => 'Existe deuda extraordinaria', 'deuda' => $deuda, 'tipo' => 'hay_deuda_extr', 'id_institucion' => $id_institucion]);
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

            $tipo_comprobante = $request['tipo_comprobante'];
            $serie_comprobante = $request['serie_comprobante'];
            $numero_comprobante = $request['numero_comprobante'];

            foreach ($deudas as $deuda) {
                $pago = Deuda_Ingreso::find($deuda);
                $pago->estado_pago = 1;
                $pago->fecha_hora_ingreso = $fecha_hora_ingresos;
                $pago->id_cajera = Auth::user()->id;
                $pago->tipo_comprobante = $tipo_comprobante;
                $pago->serie_comprobante = $serie_comprobante;
                $pago->numero_comprobante = $numero_comprobante;
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
                    'tipo_comprobante' => $tipo_comprobante,
                    'serie_comprobante' => $serie_comprobante,
                    'numero_comprobante' => $numero_comprobante,
                ]);

                $categoria = Categoria::find($compras[$i]);
                $monto = $compras[$i1];
                $monto_total += $monto;
                $concepto = array($categoria->nombre, $monto);
                array_push($pagos, $concepto);
            }

            //$id_razon_social = Institucion::find($request['id_institucion'])->id_razon_social;
            $comprobante = Comprobante::where('tipo', $tipo_comprobante)
                                      ->where('serie', $serie_comprobante)
                                      ->where('id_institucion', $request['id_institucion'])
                                      //->where('id_razon_social', $id_razon_social)
                                      ->first();
            $comprobante->numero_comprobante = intval($numero_comprobante);
            $comprobante->save();

            $alumno = Alumno::find($nro_documento);
            $nombre_completo = strtoupper($alumno->nombres . " " . $alumno->apellidos);

            $mensaje = 'Pagos de alumno correctamente actualizados. Puede girar manualmente el comprobante.';
            /*
            $usuario_impresora = UsuarioImpresora::find(Auth::user()->id);
            if ($usuario_impresora->tipo_impresora == 'matricial') {
                if ($tipo_comprobante == 'comprobante' || $tipo_comprobante == 'boleta') {
                    HerramientasController::imprimirBoletaCompMatricial($nro_documento, $nombre_completo, $pagos, $monto_total, $usuario_impresora->nombre_impresora);
                } elseif ($tipo_comprobante == 'factura') {
                  if (Config::get('config.usar_facturas')) {
                    HerramientasController::imprimirFacturaMatricial($nro_documento, $nombre_completo, $pagos, $monto_total, $request['ruc_cliente'], $request['razon_social'], $request['direccion'], $usuario_impresora->nombre_impresora);
                  } else {
                    $mensaje = 'Pagos de alumno actualizados. Puede girar la factura manualmente.';
                  }
                };
            } elseif ($usuario_impresora->tipo_impresora == 'ticketera') {
                if ($tipo_comprobante == 'comprobante') {
                    HerramientasController::imprimirComprobanteTicketera($nro_documento, $nombre_completo, $pagos, $monto_total, $usuario_impresora->nombre_impresora, $serie_comprobante, $numero_comprobante);
                } else {
                    $mensaje = 'Pagos de alumno actualizados. Puede girar la boleta/factura manualmente.';
                }
            }
            */
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
        $tipo = $request->tipo;
        $serie = $request->serie;
        $numero = $request->numero;
        $id_institucion = $request->id_institucion;

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
          'id_cajera' => Auth::user()->id,
          'tipo_comprobante' => $tipo,
          'serie_comprobante' => $serie,
          'numero_comprobante' => $numero,
        ]);
        // Actualizar el comprobante
        $comprobante = Comprobante::actualizar($id_institucion, $tipo, $serie, $numero);

        $mensaje = 'Venta realizada exitosamente.';

        /*
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
        */
        return response()->json(['mensaje' => $mensaje]);
      }
    }

    /**
    * Buscar los datos del comprobante y del número correlativo
    **/
    public function buscarComprobante($id_institucion, $tipo_comprobante, $json = 'false')
    {
      //$tipo_impresora = UsuarioImpresora::find(Auth::user()->id)->tipo_impresora;
      $comprobantes = Comprobante::seriesComprobante($tipo_comprobante, $id_institucion);
      foreach ($comprobantes as $comprobante) {
        $comprobante->numero_comprobante = str_pad(intval($comprobante->numero_comprobante) + 1, $comprobante->pad_izquierda, '0', STR_PAD_LEFT);
      }
      /*
      $numero = str_pad(intval($datos_comprobante->numero_comprobante) + 1, $datos_comprobante->pad_izquierda, '0', STR_PAD_LEFT);
      return response()->json([
        'serie' => $datos_comprobante->serie,
        'numero' => $numero
        ]);
      */
      //return response()->json($comprobantes);
      if ($json == 'false') {
        return $comprobantes;
      } else {
        return response()->json($comprobantes);
      }
    }

    /**
    * Buscar el número correspondiente a la serie seleccionada
    **/
    public function buscarNumeroComprobante($id_institucion, $tipo_comprobante, $serie_comprobante)
    {
      $comprobante = Comprobante::where('id_institucion', $id_institucion)
                                ->where('tipo', $tipo_comprobante)
                                ->where('serie', $serie_comprobante)
                                ->first();
      $numero_comprobante = str_pad(intval($comprobante->numero_comprobante) + 1, $comprobante->pad_izquierda, '0', STR_PAD_LEFT);
      return response()->json(['numero_comprobante' => $numero_comprobante]);
    }

    /**
     * Muestra la interfaz para generar ingresos (cobrar)
     */
    public function generarIngreso()
    {
      $modulos = Usuario_Modulos::modulosDeUsuario();
      return view('cajera.ingresos.index', ['modulos' => $modulos]);
    }
    /**
     * Retorna la lista de deudas de un alumno o los datos de un cobro extraordinario
     */
    public function buscarDatosParaCobro($codigo)
    {
      $resultado = '';
      $deudas = [];
      $categorias = [];
      $alumno = [];
      $matricula_alumno = '';
      $deuda_extraordinaria = [];
      $alertar = 'false';
      $mensaje = [];
      $id_institucion = '';
      // Buscar
      $alumno = Alumno::find($codigo);
      if ($alumno) {
        $alumno = Alumno::join('grado','alumno.id_grado','=','grado.id')
                        ->where('alumno.nro_documento','=', $codigo)
                        ->select('alumno.nro_documento', 'alumno.nombres', 'alumno.apellidos', 'grado.id_detalle', 'grado.nombre_grado')
                        ->first();
        $detalle_institucion = InstitucionDetalle::find($alumno->id_detalle);
        $id_institucion = $detalle_institucion->id_institucion;
        if (Permiso::usuarioEstaAutorizadoInstitucion(Auth::user()->id, $id_institucion)) {
          $resultado = 'alumno';
          $institucion = Institucion::find($id_institucion);
          $matricula_alumno = $institucion->nombre . ' - ' . $detalle_institucion->nombre_division . ' - ' . $alumno->nombre_grado;
          // Recuperar deudas de alumno
          $deudas = Deuda_Ingreso::deudasDeAlumno($codigo);
          // Modificar las pensiones de acuerdo a los descuentos
          $dia_limite = Configuracion::valor('dia_limite_descuento') . ' days';
          $porcentaje_descuento = floatval(Configuracion::valor('porcentaje_descuento')) / 100;
          $fecha_actual = date_create(date('Y-m-d'));
          #if ($id_institucion == '3') {
            foreach ($deudas as $deuda) {
              if ($deuda->id_institucion == '3' && $deuda->tipo == "pension" && $deuda->estado_descuento == "0") {
                $fecha_final = date_create($deuda->fecha_fin);
                date_add($fecha_final, date_interval_create_from_date_string($dia_limite));
                if ($fecha_actual <= $fecha_final) {
                  $descuento = floatval($deuda->monto) * $porcentaje_descuento;
                  $deuda->descuento = $descuento;
                }
              }
            }
          #}
          // Recuperar los montos a cancelar de cada deuda
          foreach ($deudas as $deuda) {
            $deuda['monto_cancelar'] = floatval($deuda->saldo) - floatval($deuda->descuento);
            $deuda['monto_pagado'] = floatval($deuda->saldo) - floatval($deuda->descuento);
          }
          // Recuperar las categorías ordinarias para el alumno
          $categorias = Categoria::categoriasParaInstitucion($id_institucion);
        } else {
          $resultado = 'no_autorizado';
          $alertar = 'true';
          $mensaje['titulo'] = 'ERROR';
          $mensaje['contenido'] = 'Usuario no autorizado para realizar este cobro.';
        }
      } else {
        $deuda_extraordinaria = Deuda_Ingreso::find($codigo);
        if ($deuda_extraordinaria) {
          if ($deuda_extraordinaria->cliente_extr != null && $deuda_extraordinaria->descripcion_extr != null) {
            if ($deuda_extraordinaria->estado_pago == 0) {
              $id_institucion = Categoria::institucionDeCategoria($deuda_extraordinaria->id_categoria);
              if (Permiso::usuarioEstaAutorizadoInstitucion(Auth::user()->id, $id_institucion)) {
                $resultado = 'extraordinario';
              } else {
                $resultado = 'no_autorizado';
                $alertar = 'true';
                $mensaje['titulo'] = 'ERROR';
                $mensaje['contenido'] = 'Usuario no autorizado para realizar este cobro.';
              }
            } else {
              $resultado = 'deuda_cancelada';
              $alertar = 'true';
              $mensaje['titulo'] = 'ERROR';
              $mensaje['contenido'] = 'Deuda ya fue cancelada.';
            }
          } else {
            $resultado = 'no_existe';
            $alertar = 'true';
            $mensaje['titulo'] = 'ERROR';
            $mensaje['contenido'] = 'No se encuentra el código de pago.';
          }
        } else {
          $resultado = 'no_existe';
          $alertar = 'true';
          $mensaje['titulo'] = 'ERROR';
          $mensaje['contenido'] = 'No se encuentra el código de pago.';
        }
      }
      // Retornar la respuesta
      $respuesta = [
        'resultado' => $resultado,
        'deudas' => $deudas,
        'categorias' => $categorias,
        'alumno' => $alumno,
        'matricula_alumno' => $matricula_alumno,
        'deuda_extraordinaria' => $deuda_extraordinaria,
        'alertar' => $alertar,
        'mensaje' => $mensaje,
        'id_institucion' => $id_institucion,
      ];
      return $respuesta;
    }
    /**
     * Graba un pago
     */
    public function grabarIngreso(Request $request)
    {
      $resultado = 'true';
      $mensaje = [];
      try {
        // Recuperar los valores enviados
        $nro_documento = $request->input('nro_documento');
        $deudas_seleccionadas = $request->input('deudas_seleccionadas');
        $conceptos_adicionales = $request->input('conceptos_adicionales');
        $tipo_comprobante = $request->input('tipo_comprobante');
        $comprobante = $request->input('comprobante');
        $id_institucion = $request->input('id_institucion');
        // Recuperar la fecha - hora
        $fecha_hora_ingreso = date('Y-m-d H:i:s');
        // Guardar los pagos
        if (isset($deudas_seleccionadas)) {
          foreach ($deudas_seleccionadas as $pago) {
            if (floatval($pago['monto_pagado']) < floatval($pago['monto_cancelar'])) {
              // Se crea la amortización
              Deuda_Ingreso::create([
                'saldo' => $pago['monto_pagado'],
                'estado_pago' => 1,
                'fecha_hora_ingreso' => $fecha_hora_ingreso,
                'id_categoria' => $pago['id_categoria'],
                'id_alumno' => $nro_documento,
                'id_cajera' => Auth::user()->id,
                'tipo_comprobante' => $tipo_comprobante,
                'serie_comprobante' => $comprobante['serie'],
                'numero_comprobante' => $comprobante['numero_comprobante'],
              ]);
              // Se actualiza la deuda
              $deuda = Deuda_Ingreso::find($pago['id']);
              //$deuda->saldo = floatval($pago['monto_cancelar']) - $pago['monto_pagado'];
              $deuda->saldo = $pago['saldo'] - $pago['monto_pagado'];
              $deuda->save();
            } else {
              // Se actualiza la deuda
              $deuda = Deuda_Ingreso::find($pago['id']);
              $deuda->estado_pago = 1;
              $deuda->fecha_hora_ingreso = $fecha_hora_ingreso;
              $deuda->id_cajera = Auth::user()->id;
              $deuda->tipo_comprobante = $tipo_comprobante;
              $deuda->serie_comprobante = $comprobante['serie'];
              $deuda->numero_comprobante = $comprobante['numero_comprobante'];
              $deuda->save();
            }
          }
        }
        // Guardar los conceptos adicionales
        $id_matricula = Alumno::find($nro_documento)->id_matricula;
        if (isset($conceptos_adicionales)) {
          foreach ($conceptos_adicionales as $concepto) {
            Deuda_Ingreso::create([
              'saldo' => $concepto['total'],
              'estado_pago' => 1,
              'id_categoria' => $concepto['id'],
              'id_alumno' => $nro_documento,
              'id_cajera' => Auth::user()->id,
              'fecha_hora_ingreso' => $fecha_hora_ingreso,
              'tipo_comprobante' => $tipo_comprobante,
              'serie_comprobante' => $comprobante['serie'],
              'numero_comprobante' => $comprobante['numero_comprobante'],
              'id_matricula' => $id_matricula,
            ]);
          }
        }
        // Actualizar el comprobante
        $comprobante = Comprobante::actualizar($id_institucion, $tipo_comprobante, $comprobante['serie'], $comprobante['numero_comprobante']);
      } catch (Exception $e) {
        $resultado = 'false';
        $mensaje['titulo'] = 'ERROR';
        $mensaje['contenido'] = $e->getMessage();
      }
      $respuesta = array(
        'resultado' => $resultado,
        'mensaje' => $mensaje,
      );
      return $respuesta;
    }
    /**
     * Imprime el comprobante
     */
    public function imprimirComprobante(Request $request)
    {
      // Recuperar los valores enviados
      $fecha_hora = date('Y-m-d H:i:s');
      $nro_documento = $request->input('nro_documento');
      $alumno = Alumno::datosAlumno($nro_documento);
      $deudas_seleccionadas = json_decode($request->input('deudas_seleccionadas'));
      $conceptos_adicionales = json_decode($request->input('conceptos_adicionales'));
      $tipo_comprobante = $request->input('tipo_comprobante');
      $comprobante = json_decode($request->input('comprobante'));
      // Recuperar el total
      $total = 0;
      foreach ($deudas_seleccionadas as $deuda) {
        $total += floatval($deuda->monto_pagado);
      }
      foreach ($conceptos_adicionales as $concepto) {
        $total += floatval($concepto->total);
      }
      $total = number_format($total, 2);
      $letras = NumeroALetras::convertir($total, 'soles', 'centimos');
      // Direccionar a la vista
      $modulos = Usuario_Modulos::modulosDeUsuario();
      return view('cajera.ingresos.comprobante', [
        'fecha_hora' => $fecha_hora,
        'nro_documento' => $nro_documento,
        'alumno' => $alumno,
        'pagos' => $deudas_seleccionadas,
        'conceptos' => $conceptos_adicionales,
        'total' => $total,
        'letras' => $letras,
        'tipo_comprobante' => $tipo_comprobante,
        'comprobante' => $comprobante,
        'modulos' => $modulos
        ]);
    }
    /**
     * Guardar un cobro extraordinario
     */
    public function grabarIngresoExtraordinario(Request $request)
    {
      $resultado = 'true';
      $id_institucion = $request->input('id_institucion');
      $tipo_comprobante = $request->input('tipo_comprobante');
      $comprobante = $request->input('comprobante');
      // Actualizar el cobro
      $deuda_extraordinaria = $request->input('deuda_extraordinaria');
      $deuda = Deuda_Ingreso::find($deuda_extraordinaria['id']);
      $deuda->estado_pago = 1;
      $deuda->fecha_hora_ingreso = date('Y-m-d H:i:s');
      $deuda->id_cajera = Auth::user()->id;
      $deuda->tipo_comprobante = $tipo_comprobante;
      $deuda->serie_comprobante = $comprobante['serie'];
      $deuda->numero_comprobante = $comprobante['numero_comprobante'];
      $deuda->save();
      // Actualizar el comprobante
      $comprobante = Comprobante::actualizar($id_institucion, $tipo_comprobante, $comprobante['serie'], $comprobante['numero_comprobante']);
      // Retornar la respuesta
      $respuesta = [
        'resultado' => $resultado
      ];
      return $respuesta;
    }
    /**
     * Imprime el comprobante extraordinario
     */
    public function imprimirComprobanteExtraordinario(Request $request)
    {
      // Recuperar los valores enviados
      $fecha_hora = date('Y-m-d H:i:s');
      $deuda = json_decode($request->input('deuda_extraordinaria'));
      $tipo_comprobante = $request->input('tipo_comprobante');
      $comprobante = json_decode($request->input('comprobante'));
      // Recuperar el total
      $total = number_format($deuda->saldo, 2);
      $letras = NumeroALetras::convertir($total, 'soles', 'centimos');
      // Direccionar a la vista
      $modulos = Usuario_Modulos::modulosDeUsuario();
      return view('cajera.ingresos.comprobante_extr', [
        'fecha_hora' => $fecha_hora,
        'pago' => $deuda,
        'total' => $total,
        'letras' => $letras,
        'tipo_comprobante' => $tipo_comprobante,
        'comprobante' => $comprobante,
        'modulos' => $modulos,
        ]);
    }
    /**
     * Imprime el comprobante múltiple
     */
    public function imprimirComprobanteMultiple(Request $request)
    {
      // Recuperar los valores enviados
      $fecha_hora = date('Y-m-d H:i:s');
      $id_categoria = $request->input('id_categoria');
      $categoria = Categoria::find($id_categoria);
      $dni = $request->input('dni');
      $nombre = $request->input('nombre');
      $ruc = $request->input('ruc');
      $razon_social = $request->input('razon_social');
      $direccion = $request->input('direccion');
      $tipo_comprobante = $request->input('tipo');
      // Recuperar el total
      $total = number_format($categoria->monto, 2);
      $letras = NumeroALetras::convertir($total, 'soles', 'centimos');
      // Direccionar a la vista
      $modulos = Usuario_Modulos::modulosDeUsuario();
      return view('cajera.ingresos.comprobante_multiple', [
        'fecha_hora' => $fecha_hora,
        'pago' => $categoria,
        'total' => $total,
        'letras' => $letras,
        'tipo_comprobante' => $tipo_comprobante,
        'dni' => $dni,
        'nombre' => $nombre,
        'ruc' => $ruc,
        'razon_social' => $razon_social,
        'direccion' => $direccion,
        'modulos' => $modulos,
        ]);
    }
}
