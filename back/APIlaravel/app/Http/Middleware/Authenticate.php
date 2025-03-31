<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Verifica la autenticación para cada guard (si es necesario)
        if (Auth::check()) {
            return $next($request); // Continúa con la petición si el usuario está autenticado
        }

        // Si el usuario no está autenticado, retorna una respuesta de error o redirige
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}