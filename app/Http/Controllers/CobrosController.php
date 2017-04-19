<?php

namespace JSoria\Http\Controllers;

use Auth;
use DB;
use Config;
use Illuminate\Http\Request;
use JSoria\Alumno;
use JSoria\Categoria;
use JSoria\Configuracion;
use JSoria\Comprobante;
use JSoria\Deuda_Ingreso;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;
use JSoria\Http\Controllers\HerramientasController;
use JSoria\Institucion;
use JSoria\InstitucionDetalle;
use JSoria\Permiso;
use NumeroALetras;

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
      return view('cajera.cobros.index', ['categorias' => $categorias]);
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
        return response()->json(['mensaje' => $mensaje]);
      }
    }
    /**
    * Buscar los datos del comprobante y del número correlativo
    **/
    public function buscarComprobante($id_institucion, $tipo_comprobante, $json = 'false')
    {
      $comprobantes = Comprobante::seriesComprobante($tipo_comprobante, $id_institucion);
      foreach ($comprobantes as $comprobante) {
        $comprobante->numero_comprobante = str_pad(intval($comprobante->numero_comprobante) + 1, $comprobante->pad_izquierda, '0', STR_PAD_LEFT);
      }
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
      return view('cajera.ingresos.index');
    }
    /**
     * Retorna la lista de deudas de un alumno o los datos de un cobro extraordinario
     */
    public function buscarDatosParaCobro($codigo)
    {
      try {
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
            $dia_limite = Configuracion::valor('dia_limite_descuento', 1);
            if ($id_institucion == 4) {
              $dia_limite = Configuracion::valor('dia_limite_descuento_ulp', 1);
            }
            $dia_limite = $dia_limite . ' days';
            $porcentaje_descuento = floatval(Configuracion::valor('porcentaje_descuento', 0)) / 100;
            if ($id_institucion == 4) {
              $porcentaje_descuento = floatval(Configuracion::valor('porcentaje_descuento_ulp', 0)) / 100;
            }
            $fecha_actual = date_create(date('Y-m-d'));
            foreach ($deudas as $deuda) {
              if (($deuda->id_institucion == '3' || $deuda->id_institucion == '4') && $deuda->tipo == "pension" && $deuda->estado_descuento == "0") {
                $fecha_final = date_create($deuda->fecha_fin);
                date_add($fecha_final, date_interval_create_from_date_string($dia_limite));
                if ($fecha_actual <= $fecha_final) {
                  $descuento = floatval($deuda->monto) * $porcentaje_descuento;
                  $deuda->descuento = $descuento;
                }
              }
            }
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
      } catch (\Exception $e) {
        return [
          'resultado' => 'false',
          'alertar' => 'true',
          'mensaje' => [ 'titulo' => 'Error.', 'contenido' => $e->getMessage() ]
        ];
      }
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
        $comprobante = $request->input('comprobante');
        $id_institucion = $request->input('id_institucion');
        // Recuperar la fecha - hora
        $fecha_hora_ingreso = date('Y-m-d H:i:s');
        // Iniciar transacción
        DB::beginTransaction();
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
                'tipo_comprobante' => $comprobante['tipo'],
                'serie_comprobante' => $comprobante['serie'],
                'numero_comprobante' => $comprobante['numero'],
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
              $deuda->tipo_comprobante = $comprobante['tipo'];
              $deuda->serie_comprobante = $comprobante['serie'];
              $deuda->numero_comprobante = $comprobante['numero'];
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
              'tipo_comprobante' => $comprobante['tipo'],
              'serie_comprobante' => $comprobante['serie'],
              'numero_comprobante' => $comprobante['numero'],
              'id_matricula' => $id_matricula,
            ]);
          }
        }
        // Actualizar el comprobante
        $comprobante = Comprobante::actualizar($id_institucion, $comprobante['tipo'], $comprobante['serie'], $comprobante['numero']);
        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
        $resultado = 'false';
        $mensaje['titulo'] = 'Error.';
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
      return view('cajera.ingresos.comprobante', [
        'fecha_hora' => $fecha_hora,
        'nro_documento' => $nro_documento,
        'alumno' => $alumno,
        'pagos' => $deudas_seleccionadas,
        'conceptos' => $conceptos_adicionales,
        'total' => $total,
        'letras' => $letras,
        'comprobante' => $comprobante,
        ]);
    }
    /**
     * Guardar un cobro extraordinario
     */
    public function grabarIngresoExtraordinario(Request $request)
    {
      $resultado = 'true';
      $id_institucion = $request->input('id_institucion');
      $comprobante = $request->input('comprobante');
      // Actualizar el cobro
      $deuda_extraordinaria = $request->input('deuda_extraordinaria');
      $deuda = Deuda_Ingreso::find($deuda_extraordinaria['id']);
      $deuda->estado_pago = 1;
      $deuda->fecha_hora_ingreso = date('Y-m-d H:i:s');
      $deuda->id_cajera = Auth::user()->id;
      $deuda->tipo_comprobante = $comprobante['tipo'];
      $deuda->serie_comprobante = $comprobante['serie'];
      $deuda->numero_comprobante = $comprobante['numero'];
      $deuda->save();
      // Actualizar el comprobante
      $comprobante = Comprobante::actualizar($id_institucion, $comprobante['tipo'], $comprobante['serie'], $comprobante['numero']);
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
      $comprobante = json_decode($request->input('comprobante'));
      // Recuperar el total
      $total = number_format($deuda->saldo, 2);
      $letras = NumeroALetras::convertir($total, 'soles', 'centimos');
      // Direccionar a la vista
      return view('cajera.ingresos.comprobante_extr', [
        'fecha_hora' => $fecha_hora,
        'pago' => $deuda,
        'total' => $total,
        'letras' => $letras,
        'comprobante' => $comprobante,
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
        ]);
    }
}
