<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SoloCelular
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = (string) $request->header('User-Agent', '');

        if (preg_match('/Mobile|Android|iPhone|iPad|iPod|IEMobile|Opera Mini/i', $userAgent)) {
            return redirect()->route('movil');
        }

        return $next($request);
    }
}