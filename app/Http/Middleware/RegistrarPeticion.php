<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RegistrarPeticion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        Log::info('Petición registrada por middleware', [
            'metodo' => $request->method(),
            'ruta' => $request->path(),
            'usuario_id' => optional($request->user())->id,
            'ip' => $request->ip(),
            'estado' => $response->getStatusCode(),
            'user_agent' => $request->userAgent(),
            'fecha' => now()->toDateTimeString(),
        ]);

        return $response;
    }
}