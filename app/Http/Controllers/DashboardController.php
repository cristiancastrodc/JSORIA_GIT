<?php namespace JSoria\Http\Controllers;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use Illuminate\Http\Request;

use JSoria\Usuario;
use JSoria\UsuarioImpresora;

use Auth;

class DashboardController extends Controller {

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function escritorio()
  {
    $usuario = Auth::user();
    if ($usuario->tipo != 'Cajera') {
      return view('layouts.dashboard');
    } else {
      $tipo_impresora = UsuarioImpresora::find($usuario->id)->tipo_impresora;
      return view('cajera.dashboard.index', compact('tipo_impresora'));
    }
  }

}
