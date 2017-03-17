<?php

namespace JSoria\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Guard;
use JSoria\Usuario_Modulos;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Guard $auth)
    {
        // Using Closure based composers...
        view()->composer('*', function ($view) use ($auth) {
            // get the current user
            $usuario = $auth->user();
            if ($usuario) {
                $modulos = Usuario_Modulos::modulosDeUsuario();
                // pass the data to the view
                if ($modulos) {
                    $view->with('modulos', $modulos);
                }
                else {
                    $view->with('modulos', []);
                }
            } else {
                $view->with('modulos', []);
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
