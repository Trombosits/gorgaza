<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('auth_user')) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu untuk melakukan booking.',
                    'redirect' => '/login',
                ], 401);
            }

            if ($request->isMethod('get')) {
                session()->put('intended_url', $request->fullUrl());
            }

            return redirect('/login')->with('error', 'Silakan login terlebih dahulu untuk melakukan booking.');
        }

        return $next($request);
    }
}
