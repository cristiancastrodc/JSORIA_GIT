<?php

namespace JSoria\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use JSoria\Http\Controllers\Controller;
use JSoria\Http\Requests;
use JSoria\Deuda_Ingreso;
use JSoria\User;

class AdminIngresosController extends Controller
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
    $cajeras = User::getCajerasUsuario(Auth::user()->id);
    return view('admin.ingreso.index', ['cajeras' => $cajeras]);
  }
}
