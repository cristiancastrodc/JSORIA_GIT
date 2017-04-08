<?php

namespace JSoria\Http\Controllers;

use Illuminate\Http\Request;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;
use JSoria\Categoria;
use JSoria\Grado;
use JSoria\InstitucionDetalle;

class InstitucionDetalleController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    public function divisionesInstitucion(Request $request, $id_institucion)
    {
        if ($request->ajax()) {
            $divisiones = InstitucionDetalle::divisiones_institucion($id_institucion);
            return response()->json($divisiones);
        }
    }

    public function gradosDetalle(Request $request, $id_detalle_institucion)
    {
        if ($request->ajax()) {
            $grados = InstitucionDetalle::grados_detalle($id_detalle_institucion);
            return response()->json($grados);
        }
    }
    public function matriculas(Request $request, $id_detalle_institucion)
    {
        if ($request->ajax()) {
            $matricula = InstitucionDetalle::matricula($id_detalle_institucion);
            return response()->json($matricula);
        }
    }

    /*
     * Retorna la colección de divisiones para poblar los select (html)
     */
    public function detalleInstitucionParaSelect($id_institucion)
    {
        return InstitucionDetalle::divisionesParaSelect($id_institucion);
    }
    /*
     * Retorna el detalle de una institución.
     */
    public function detalleInstitucion($id_institucion)
    {
      return InstitucionDetalle::detalleInstitucion($id_institucion);
    }
    /*
     * Retorna los grados y matrículas correspondientes a un detalle institución.
     */
    public function recuperarGradosYMatriculas($id_detalle)
    {
      // Recuperar los grados
      $grados = Grado::grados($id_detalle);
      $fecha = date('Y-m-d');
      $matriculas = Categoria::matriculasActivas($id_detalle, $fecha);
      $respuesta = array(
        'grados' => $grados,
        'matriculas' => $matriculas,
        'fecha' => $fecha
      );
      return $respuesta;
    }
    /*
     * Retorna las matrículas correspondientes a un detalle institución
     */
    public function recuperarMatriculas($id_detalle)
    {
      // Recuperar los grados
      $matriculas = Categoria::matriculasParaCerrar($id_detalle);
      $respuesta = array(
        'matriculas' => $matriculas
      );
      return $respuesta;
    }
    /*
     * Retorna la lista de matrículas para agregar deudas anteriores
     */
    public function recuperarTodasMatriculas($id_detalle)
    {
      // Recuperar los grados
      $matriculas = Categoria::todasMatriculas($id_detalle);
      $respuesta = array(
        'matriculas' => $matriculas,
      );
      return $respuesta;
    }
}
