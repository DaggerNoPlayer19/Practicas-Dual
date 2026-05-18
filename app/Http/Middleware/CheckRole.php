<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!Auth::check() || !$user->hasRole($role)) {
            abort(403, 'Unauthorized access');
        }
        return $next($request);
    }
}

