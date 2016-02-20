<?php namespace JSoria\Http\Controllers;

use JSoria\Http\Requests;
use JSoria\Http\Controllers\Controller;

use Illuminate\Http\Request;

class FrontController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('login');
	}

}
