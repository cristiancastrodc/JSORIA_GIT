<?php namespace JSoria\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;
use JSoria\Balance;
use JSoria\Usuario;
use JSoria\UsuarioImpresora;

class DashboardController extends Controller {

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function escritorio()
  {
    $tipo = strtolower(Auth::user()->tipo);
    if ($tipo == 'tesorera') {
      $balance = Balance::where('id_tesorera', Auth::user()->id)->first();
      if ($balance) {
        return view('layouts.dashboard');
      } else {
        return view('tesorera.inicial.index');
      }
    } else if ($tipo == 'cajera') {
      $tipo_impresora = UsuarioImpresora::find($usuario->id)->tipo_impresora;
      return view('cajera.dashboard.index', compact('tipo_impresora'));
    } else {
      return view('layouts.dashboard');
    }
  }

}
