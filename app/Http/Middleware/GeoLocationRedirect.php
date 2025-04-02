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
        if (str_starts_with($request->path(), 'admin')) {
            return $next($request);
        }

        if ($request->cookie('geo_redirected')) {
            return $next($request);
        }

        if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg)$/i', $request->getRequestUri())) {
            return $next($request);
        }

        $currentUrl = $request->fullUrl();
        $geoData = session('geo_location');

        if (!$geoData) {
            try {
                $ip = $this->getClientIP();
                $response = Http::timeout(5)->get("http://ipwho.is/{$ip}");
                $data = $response->json();

                if (!is_array($data) || !isset($data['success']) || $data['success'] !== true) {
                    Log::error('La API de geolocalización devolvió datos inválidos o un error.');
                    $data = [];
                }

                session(['geo_location' => $data]);
                $geoData = $data;
            } catch (\Exception $e) {
                Log::error('Error en la detección de ubicación: ' . $e->getMessage());
                $geoData = [];
            }
        }

        if (isset($geoData['country_code'])) {
            $countryCode = strtoupper($geoData['country_code']);
            Log::info('País detectado: ' . $countryCode);

            $redirectUrls = config('geolocation.redirects', [
                'AR' => 'https://argentina.javm.tech',
                'CL' => 'https://chile.javm.tech',
                'CO' => null,
            ]);

            if (isset($redirectUrls[$countryCode]) && $redirectUrls[$countryCode] !== null) {
                $targetUrl = $redirectUrls[$countryCode];

                if ($currentUrl !== $targetUrl) {
                    $cookie = cookie()->forever('geo_redirected', 'true', null, null, false, false);

                    return redirect()->away($targetUrl)->withCookie($cookie);
                }
            }
        }

        $cookie = cookie()->forever('geo_redirected', 'true', null, null, false, false);

        return $next($request)->withCookie($cookie);
    }

    private function getClientIP()
    {
        $headers = [
            'HTTP_CF_CONNECTING_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];

        usleep(100000);


        foreach ($headers as $header) {
            if (isset($_SERVER[$header])) {
                $ips = explode(',', $_SERVER[$header]);
                $ip = trim($ips[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return request()->ip();
    }
}
