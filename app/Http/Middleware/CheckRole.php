<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user() || ! $request->user()->hasRole($roles)) {
            return response()->json(['message' => 'No autorizado.'], 403);
            // O puedes redirigir a una página de error
            // O puedes retornar una respuesta json
            // return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $next($request);
    }
}
