<?php

namespace JSoria\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;
use JSoria\Balance;
use JSoria\Deuda_Ingreso;
use JSoria\Retiro;
use JSoria\User;

class RetirosController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $id_cajera = Auth::user()->id;
    $retiro = Retiro::join('usuario', 'retiro.id_usuario', '=', 'usuario.id')
                    ->where('retiro.id_cajera','=',$id_cajera)
                    ->where('retiro.estado','=','0')
                    ->select('retiro.id','retiro.monto','retiro.fecha_hora_creacion','usuario.nombres','usuario.apellidos')
                    ->get();
    return view('cajera.retiros.index', compact('retiro'));
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      if ($request->ajax()) {
        // Recuperar el arreglo de ids de cobros
        $ids_deuda_ingreso = $request->ids_cobros;
        $monto = 0;
        $crearRetiro = true;
        $retiro = NULL;
        foreach ($ids_deuda_ingreso as $id) {
          $ingreso = Deuda_Ingreso::where('id', $id)->where('estado_retiro', 0)->first();
          if ($ingreso) {
            $monto += $ingreso->saldo - $ingreso->descuento;
            if ($crearRetiro) {
              $retiro = Retiro::create([
                          'id_usuario' => Auth::user()->id,
                          'fecha_hora_creacion' => date('Y-m-d H:i:s'),
                          'id_cajera' => $request->id_cajera
                        ]);
              $crearRetiro = false;
            }
            $ingreso->update(['estado_retiro' => 1, 'id_retiro' => $retiro->id]);
          }
        }
        if (!$crearRetiro) {
          $retiro->update([ 'monto' => $monto ]);
          return response()->json(['resultado' => 'true', 'id_retiro' => $retiro->id]);
        } else {
          return response()->json(['resultado' => 'false', 'mensaje' => 'No existen ingresos para retirar.']);
        }
      }
    } catch (\Exception $e) {
      return response()->json(['resultado' => 'false', 'mensaje' => $e->getMessage()]);
    }
  }
  /** Recuperar los cobros asociados al administrador **/
  public function retiroAdmin(Request $request, $id_cajera)
  {
    if ($request->ajax()) {
      $pagos = Deuda_Ingreso::retiroAdmin($id_cajera);
      return response()->json($pagos);
    }
  }
  public function retiroTesorera(Request $request, $id_cajera)
  {
    if ($request->ajax()) {
      $pagos = Deuda_Ingreso::retiroTesorera($id_cajera, Auth::user()->id);
      return response()->json($pagos);
    }
  }
  public function confirmar(Request $request)
  {
    if ($request->ajax()) {
      $retiro = $request['retiro'];
      $pass = $request['pass'];

      $idusuario = Retiro::find($retiro);
      $user = $idusuario->id_usuario;
      $monto_total = $idusuario->monto;

      $tesorera = User::find($user);
      $contra = $tesorera->password;

      if(\Hash::check($pass , $contra)){
        /** Actualizar el estado del retiro **/
        $fecha_hora_retiro = date('Y-m-d H:i:s');
        Retiro::where('id', '=', $retiro)
              ->Update([
                'estado' => '1',
                'fecha_hora_retiro' => $fecha_hora_retiro
              ]);
        /** Actualizar el estado de los cobros asociados al retiro **/
        Deuda_Ingreso::where('id_retiro', $retiro)
                     ->update(['estado_retiro' => '2']);
        /** Actualizar la tabla de balance **/
        $balance = Balance::where('fecha', date('Y-m-d'))
                          ->where('id_tesorera', $user)
                          ->first();
        if ($balance) {
          $balance->ingresos += $monto_total;
          $balance->save();
        }
        else {
          $saldo = 0;
          $registro_anterior = Balance::where('id_tesorera', $user)
                                      ->orderBy('fecha', 'desc')
                                      ->first();
          if ($registro_anterior) {
            $saldo = $registro_anterior['ingresos'] - $registro_anterior['egresos'];
          }
          $balance_ingreso = $monto_total + $saldo;
          Balance::create([
              'fecha' => date('Y-m-d'),
              'id_tesorera' => $user,
              'ingresos' => $balance_ingreso,
              'egresos' => 0
          ]);
        }
        return response()->json(['mensaje' => 'El Retiro fue procesado correctamente.', 'tipo' => '']);
      }else{
        return response()->json(['mensaje' => 'Contraseña incorrecta.', 'tipo' => 'error']);
      }
    }
  }
  /**
   * Lista los retiros del usuario autenticado.
   */
  public function listarRetiros()
  {
    return Retiro::retirosUsuario(Auth::user()->id);
  }
  /**
   * Elimina el retiro y restaura sus cobros asociados.
   */
  public function eliminarRetiro($id)
  {
    $respuesta = [];
    try {
      DB::beginTransaction();
      // Actualizar los cobros
      $retiro = Retiro::find($id);
      if ($retiro) {
        Deuda_Ingreso::where('id_retiro', $id)
                     ->update(['id_retiro' => NULL, 'estado_retiro' => 0]);
        $retiro->delete();
        DB::commit();
        $respuesta['resultado'] = 'true';
      } else {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = 'Retiro no existe.';
      }
    } catch (\Exception $e) {
      DB::rollback();
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
  }
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $cobros = Deuda_Ingreso::cobrosDeRetiro($id);
    return view('common.retiro.resumen', [ 'cobros' => $cobros, 'id_retiro' => $id ]);
  }
  /**
   * Mostrar el reporte con el resumen del retiro.
   *
   * @param  int  $id_retiro
   */
  public function procesarReporteResumen($id_retiro)
  {
    $cobros = Deuda_Ingreso::cobrosDeRetiro($id_retiro);
    $total = $cobros->sum('monto');
    $fecha_archivo = date('d-m-Y H:i:s');
    $archivo = 'Resumen de Creación de Retiro' . '-' . $fecha_archivo;
    $fecha = date('d-m-Y');
    $view = \View::make('common.retiro.reporte_resumen', ['cobros' => $cobros, 'total' => $total ,'fecha' => $fecha])->render();
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream($archivo);
  }
}
