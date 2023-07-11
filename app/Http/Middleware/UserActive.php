<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!\Auth::user()->is_active) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            abort(403, 'Akun anda tidak aktif');
        }
        return $next($request);
    }
}
