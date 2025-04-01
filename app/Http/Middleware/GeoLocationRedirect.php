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
        // No redirecciona el admin
        if (str_starts_with($request->path(), 'admin')) {
            return $next($request);
        }

        try {
            // Obtener la IP real del cliente
            $ip = $this->getClientIP();
            Log::info('IP detectada: ' . $ip);

            // Usar ipapi.co para geolocalización
            $response = Http::get("https://ipapi.co/{$ip}/json/");
            $data = $response->json();

            Log::info('Datos de localización:', is_array($data) ? $data : []);

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

    private function getClientIP()
    {
        // Verificar encabezados comunes para proxies y CDNs
        $headers = [
            'HTTP_CF_CONNECTING_IP', // Cloudflare
            'HTTP_X_FORWARDED_FOR',  // Proxy estándar
            'HTTP_X_REAL_IP',        // Nginx proxy
            'HTTP_CLIENT_IP',        // Proxy compartido
            'HTTP_X_FORWARDED',      // Proxy general
            'HTTP_FORWARDED_FOR',    // Proxy general
            'HTTP_FORWARDED',        // Estándar RFC
            'REMOTE_ADDR',           // IP directa
        ];
        
        foreach ($headers as $header) {
            if (isset($_SERVER[$header])) {
                // Muchos proxies separan las IPs con comas
                // La primera es la IP del cliente original
                $ips = explode(',', $_SERVER[$header]);
                $ip = trim($ips[0]);
                
                // Validar que sea una IP válida
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    Log::info('IP obtenida desde encabezado ' . $header . ': ' . $ip);
                    return $ip;
                }
            }
        }
        
        // Si todo falla, usar la que proporciona Laravel
        return request()->ip();
    }
}
