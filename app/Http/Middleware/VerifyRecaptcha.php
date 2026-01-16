<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifyRecaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Posibilidad de saltar la verificación (útil para Staging/Desarrollo)
        if (config('services.recaptcha.skip', env('SKIP_RECAPTCHA', false))) {
            return $next($request);
        }

        // Solo verificar en login POST
        if ($request->isMethod('post') && $request->route() && $request->route()->named('login')) {
            $recaptchaToken = $request->input('recaptcha_token');
            
            if (!$recaptchaToken) {
                return back()->withErrors(['email' => 'Error de verificación. Por favor, intenta nuevamente.']);
            }

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $recaptchaToken,
                'remoteip' => $request->ip()
            ]);


            $result = $response->json();

            if (!$result['success'] || $result['score'] < 0.5) {
                return back()->withErrors(['email' => 'Verificación de seguridad fallida. Por favor, intenta nuevamente.']);
            }
        }

        return $next($request);
    }
}
