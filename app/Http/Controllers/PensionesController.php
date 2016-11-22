<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;

use JSoria\Http\Requests;
use JSoria\Http\Requests\PensionesCreateRequest ;
use JSoria\Http\Requests\PensionesUpdateRequest;
use JSoria\Http\Controllers\Controller;

use JSoria\Categoria;
use JSoria\Deuda_Ingreso;
use JSoria\Usuario_Modulos;

class PensionesController extends Controller
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
        $modulos = Usuario_Modulos::modulosDeUsuario();
        return view('admin.pension.index', ['modulos' => $modulos]);
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
    public function store(PensionesCreateRequest $request)
    {
        if ($request->ajax()) {
            Categoria::create($request->all());
            return response()->json([
                'mensaje' => 'Pensión creada exitosamente.'
            ]);
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
    public function update(PensionesUpdateRequest $request, $id)
    {
        $categoria = Categoria::find($id);

        $operacion = $request['operacion'];

        if ($operacion == 'actualizar') {
            $categoria->monto = $request['monto'];
            $categoria->save();

            /* Cambiar deudas de la pension */
            Deuda_Ingreso::where('id_categoria', '=', $id)->where('estado_pago', '=', 0)->update(['saldo' => $request['monto']]);
        } elseif ($operacion == 'estado') {
            $categoria->estado = $request['estado'];
            $categoria->save();
        }

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
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

    public function listaPensiones(Request $request, $id_detalle_institucion, $anio) {
        if ($request->ajax()) {
            $pensiones = Categoria::pensionesDetalleAnio($id_detalle_institucion, $anio);
            return response()->json($pensiones);
        }
    }
}
