<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeoLocationRedirect
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Obtener la IP real o la IP pública
            $ip = $this->getPublicIP();
            Log::info('IP detectada: ' . $ip);

            // Usar ipapi.co en lugar de ip-api.com
            $response = Http::get("https://ipapi.co/{$ip}/json/");
            $data = $response->json();

            Log::info('Datos de localización:', $data);

            if (isset($data['country_code'])) {
                $countryCode = strtoupper($data['country_code']);
                Log::info('País detectado: ' . $countryCode);

                // Definir las redirecciones por país
                $redirectUrls = [
                    'AR' => 'https://javm.tech', // Prueba de redirección 
                    'CL' => 'https://chile.javm.tech', // Prueba de redirección chile
                    'CO' => null // Se queda en la página actual
                ];

                // Redirigir si el país está en nuestra lista
                if (isset($redirectUrls[$countryCode]) && $redirectUrls[$countryCode] !== null) {
                    Log::info('Redirigiendo a: ' . $redirectUrls[$countryCode]);
                    return redirect()->away($redirectUrls[$countryCode]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error en la detección de ubicación: ' . $e->getMessage());
        }

        return $next($request);
    }

    private function getPublicIP()
    {
        try {
            // Intentar obtener la IP pública usando un servicio externo
            $response = Http::get('https://api.ipify.org?format=json');
            $data = $response->json();
            return $data['ip'] ?? null;
        } catch (\Exception $e) {
            Log::error('Error al obtener IP pública: ' . $e->getMessage());
            return request()->ip();
        }
    }
}
