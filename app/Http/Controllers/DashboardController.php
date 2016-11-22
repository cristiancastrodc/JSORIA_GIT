<?php namespace JSoria\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;
use JSoria\Balance;
use JSoria\Usuario;
use JSoria\UsuarioImpresora;
use JSoria\Usuario_Modulos;

class DashboardController extends Controller {

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function escritorio()
  {
    $tipo = strtolower(Auth::user()->tipo);
    $modulos = Usuario_Modulos::modulosDeUsuario();
    if ($tipo == 'tesorera') {
      $balance = Balance::where('id_tesorera', Auth::user()->id)->first();
      if ($balance) {
        return view('layouts.dashboard', ['modulos' => $modulos]);
      } else {
        return view('tesorera.inicial.index', ['modulos' => $modulos]);
      }
    } else if ($tipo == 'cajera') {
      return view('cajera.ingresos.index', ['modulos' => $modulos]);
    } else {
      return view('layouts.dashboard', ['modulos' => $modulos]);
    }
  }
}
