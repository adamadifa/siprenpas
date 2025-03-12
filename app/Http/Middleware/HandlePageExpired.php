<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Response;

class HandlePageExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {
            return $next($request);
        } catch (TokenMismatchException $e) {
            return redirect('/dashboard')->with('error', 'Sesi Anda telah habis. Silakan login kembali.');
        }
        //return $next($request);
    }
}
