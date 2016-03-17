<?php

namespace JSoria\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;
use Closure;
use Session;

class Secretaria
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->user()->tipo != 'Secretaria') {
            Session::flash('error-message', 'Acceso denegado. Se requiere otro tipo de autorización.');
            return redirect()->to('escritorio');
        }
        return $next($request);
    }
}
