<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider; // Importa correctamente el RouteServiceProvider

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Verifica si el usuario ya está autenticado
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Si está autenticado, redirige según la ruta deseada
                // return redirect(RouteServiceProvider::HOME); // Esto ya debería funcionar correctamente
            }
        }

        return $next($request);
    }
}