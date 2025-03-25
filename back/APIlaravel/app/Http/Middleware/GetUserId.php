<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetUserId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Obtener el ID del usuario autenticado
            $userId = Auth::id(); // Esto devuelve el ID del usuario

            // Pasar el ID del usuario al siguiente middleware o controlador

            dd($userId);
            $request->merge(['userId' => $userId]);
        } else {
            // Si el usuario no está autenticado, redirigir o retornar error
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}