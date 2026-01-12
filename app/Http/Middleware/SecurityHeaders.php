<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Security headers
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), midi=(), sync-xhr=(), microphone=(), camera=(), magnetometer=(), gyroscope=(), fullscreen=(self), payment=()');
        
        // Content Security Policy (Básico y seguro)
        // Nota: Si usas scripts externos como WhatsApp o FontAwesome, asegúrate de permitirlos aquí.
        // Por ahora, permitimos los CDNs que ya usamos.
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://code.jquery.com; " .
               "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com; " .
               "img-src 'self' data: https://res.cloudinary.com https://*.whatsapp.com; " .
               "font-src 'self' https://cdnjs.cloudflare.com https://fonts.gstatic.com; " .
               "connect-src 'self' https://res.cloudinary.com; " .
               "frame-src 'self';";
               
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
