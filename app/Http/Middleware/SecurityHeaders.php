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
        $csp = "default-src 'self' https://creamoshojasdevida.online https://www.creamoshojasdevida.online https://creamos-hojas-de-vida-67e514fac37f.herokuapp.com; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://creamoshojasdevida.online https://www.creamoshojasdevida.online https://creamos-hojas-de-vida-67e514fac37f.herokuapp.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://code.jquery.com https://cdn.datatables.net https://www.google.com https://www.gstatic.com https://www.recaptcha.net https://apis.google.com; " .
               "style-src 'self' 'unsafe-inline' https://creamoshojasdevida.online https://www.creamoshojasdevida.online https://creamos-hojas-de-vida-67e514fac37f.herokuapp.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com https://cdn.datatables.net; " .
               "img-src 'self' data: https://creamoshojasdevida.online https://www.creamoshojasdevida.online https://creamos-hojas-de-vida-67e514fac37f.herokuapp.com https://res.cloudinary.com https://*.whatsapp.com https://www.gstatic.com; " .
               "font-src 'self' data: https://cdnjs.cloudflare.com https://fonts.gstatic.com https://cdn.jsdelivr.net; " .
               "connect-src 'self' https://creamoshojasdevida.online https://www.creamoshojasdevida.online https://creamos-hojas-de-vida-67e514fac37f.herokuapp.com https://res.cloudinary.com https://cdn.jsdelivr.net https://www.google.com https://cdnjs.cloudflare.com; " .
               "frame-src 'self' https://www.google.com https://www.recaptcha.net;";


               
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
