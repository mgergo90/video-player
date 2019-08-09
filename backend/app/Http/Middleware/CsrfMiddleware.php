<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Access\AuthorizationException;
use Closure;

class CsrfMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('csrf-token') !== auth()->payload()->get('csrf-token')) {
            throw new AuthorizationException;
        }
        return $next($request);
    }
}
