<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class GeoLocationRedirect
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Obtener IP de prueba y loggear para debug
            $testIP = config('app.test_ip') ?: env('TEST_IP');
            $realIP = $request->ip();
            $ip = $testIP ?: $realIP;

            Log::info('Debug IP:', [
                'TEST_IP from env' => env('TEST_IP'),
                'Real IP' => $realIP,
                'IP being used' => $ip
            ]);

            // Determinar país directamente por la IP de prueba
            if ($ip === '181.191.255.255') {
                $countryCode = 'AR';
            } elseif ($ip === '152.231.255.255') {
                $countryCode = 'CL';
            } elseif ($ip === '181.234.255.255') {
                $countryCode = 'CO';
            } else {
                // Si no es una IP de prueba, usar el servicio de geolocalización
                $response = Http::get("http://ip-api.com/json/{$ip}");
                $data = $response->json();
                $countryCode = $data['countryCode'] ?? null;
            }

            Log::info('País detectado:', ['country' => $countryCode]);

            // Definir redirecciones
            $redirectUrls = [
                'AR' => 'https://es.wikipedia.org/wiki/Argentina',
                'CL' => 'https://es.wikipedia.org/wiki/Chile',
                'CO' => null
            ];

            // Si es Argentina o Chile, redirigir
            if ($countryCode && isset($redirectUrls[$countryCode]) && $redirectUrls[$countryCode] !== null) {
                Log::info('Intentando redirección a: ' . $redirectUrls[$countryCode]);
                
                // Forzar la redirección usando header nativo
                header('Location: ' . $redirectUrls[$countryCode]);
                exit();
            }

        } catch (\Exception $e) {
            Log::error('Error en redirección:', ['error' => $e->getMessage()]);
        }

        return $next($request);
    }
}
