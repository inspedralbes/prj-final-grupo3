<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if ($request->user() && $request->user()->token()) {
        if ($request->user()->token()->expires_at < now()) {
            $request->user()->token()->delete();
            return response()->json(['error' => 'Token expirado'], 401);
        }
    }
    
    return $next($request);
}
}
