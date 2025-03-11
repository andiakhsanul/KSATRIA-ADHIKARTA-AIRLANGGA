<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->status == 2) {
            Auth::logout();
            return redirect()->route('login')->with('warning','Akun Anda masih menunggu persetujuan admin.');
        }

        if (Auth::user()->status == 3) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Pendaftaran akun Anda telah ditolak.');
        }

        if (Auth::user()->status != 1) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak memiliki izin untuk mengakses sistem.');
        }

        return $next($request);
    }
}
