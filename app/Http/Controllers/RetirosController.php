<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;
use Crypt;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use JSoria\Deuda_Ingreso;
use JSoria\Retiro;
use JSoria\User;
use Auth;

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
                        ->select('retiro.id','retiro.monto','retiro.fecha_hora','usuario.nombres','usuario.apellidos')
                        ->get();
        return view('cajera.retiros.index', compact('retiro'));
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
        if ($request->ajax()) {
            $ids_deuda_ingreso = $request->ids_cobros;

            $monto = 0;
            $crearRetiro = true;
            $retiro = NULL;
            foreach ($ids_deuda_ingreso as $id) {
                $ingreso = Deuda_Ingreso::where('id', $id)
                           ->where('estado_retiro', 0)->first();
                if ($ingreso) {
                    $monto += $ingreso->saldo - $ingreso->descuento;
                    if ($crearRetiro) {
                        $retiro = Retiro::create(['id_usuario' => Auth::user()->id]);
                        $crearRetiro = false;
                    }
                    $ingreso->update(['estado_retiro' => 1, 'id_retiro' => $retiro->id]);
                }
            }

            if (!$crearRetiro) {
                $retiro->update(['monto' => $monto]);

                return response()->json(['mensaje' => 'Retiro creado con éxito.', 'tipo' => 'creado']);
            } else {
                return response()->json(['mensaje' => 'No existen ingresos para retirar.', 'tipo' => 'sin_cambios']);
            }
        }
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

            $tesorera = User::find($user);
            $contra = $tesorera->password;

            if(\Hash::check($pass , $contra)){
              Retiro::where('id','=',$retiro)
                      ->Update(['estado'=>'1']);
              return response()->json(['mensaje' => 'El Retiro fue procesado correctamente.', 'tipo' => '']);
            }else{
            return response()->json(['mensaje' => 'Contraseña incorrecta.', 'tipo' => 'error']);
            //return response()->json($contra);
          }
        }
    }
}
