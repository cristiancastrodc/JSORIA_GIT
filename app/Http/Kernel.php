<?php namespace JSoria\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		'JSoria\Http\Middleware\VerifyCsrfToken',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'JSoria\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'JSoria\Http\Middleware\RedirectIfAuthenticated',
		'admin' => 'JSoria\Http\Middleware\Admin',
		'tesorera' => 'JSoria\Http\Middleware\tesorera',
		'Secretaria' => 'JSoria\Http\Middleware\Secretaria',
		'Cajera' => 'JSoria\Http\Middleware\Cajera',
	];

}
