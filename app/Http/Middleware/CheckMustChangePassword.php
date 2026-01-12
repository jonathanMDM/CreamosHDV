<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMustChangePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->must_change_password) {
            // Allow access to change password route and logout
            if (!$request->routeIs('password.change') && 
                !$request->routeIs('password.update.first') && 
                !$request->routeIs('logout')) {
                return redirect()->route('password.change');
            }
        }

        return $next($request);
    }
}
