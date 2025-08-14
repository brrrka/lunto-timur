<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('two_factor_passed')) {
            return redirect()->route('two-factor.index');
        }
        return $next($request);
    }
}
