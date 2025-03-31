<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class GeoLocationRedirect
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si ya tenemos una cookie de redirección
        if ($request->cookie('country_redirect')) {
            return $next($request);
        }

        try {
            // Obtener el código del país (ya sea de prueba o real)
            $countryCode = $request->query('test_country') ?? $this->getCountryFromIP($request->ip());
            
            Log::info('País detectado: ' . $countryCode);

            // Define las URLs de redirección
            $redirectUrls = [
                'AR' => 'https://es.wikipedia.org/wiki/Argentina',
                'CL' => 'https://es.wikipedia.org/wiki/Chile',
                'CO' => null
            ];

            // Si el país está en nuestra lista y tiene URL de redirección
            if ($countryCode && isset($redirectUrls[$countryCode]) && $redirectUrls[$countryCode] !== null) {
                Log::info('Redirigiendo a: ' . $redirectUrls[$countryCode]);
                return redirect()->away($redirectUrls[$countryCode], 302); // Forzar redirección temporal
            }

        } catch (\Exception $e) {
            Log::error('Error en redirección: ' . $e->getMessage());
        }

        // Si no hay redirección, establecer la cookie de todas formas
        Cookie::queue('country_redirect', 'VISITED', 1440);
        
        return $next($request);
    }

    private function getCountryFromIP($ip)
    {
        try {
            $response = Http::get("http://ip-api.com/json/{$ip}");
            $data = $response->json();
            return $data['countryCode'] ?? null;
        } catch (\Exception $e) {
            Log::error('Error al obtener país desde IP: ' . $e->getMessage());
            return null;
        }
    }
}
