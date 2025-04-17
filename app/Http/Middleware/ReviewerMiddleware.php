<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ReviewerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // reviewer
        if (Auth::user()->role_id === 2) {
            return $next($request);
        }

        // operator
        if (Auth::user()->role_id === 1) {
            return $next($request);
        }

        return abort(403, 'Akses ditolak');
    }
}
