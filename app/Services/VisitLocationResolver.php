<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VisitLocationResolver
{
    public function resolve(?string $ip): array
    {
        if (! $ip) {
            return [
                'country' => 'Unknown',
                'city' => 'Unknown',
            ];
        }

        if ($this->isLocalOrPrivateIp($ip)) {
            return [
                'country' => 'Local environment',
                'city' => 'Local environment',
            ];
        }

        try {
            $response = Http::baseUrl((string) config('tracker.geo_api_url'))
                ->timeout(4)
                ->acceptJson()
                ->get('/'.$ip);

            if ($response->failed()) {
                return $this->unknownLocation();
            }

            $payload = $response->json();

            if (($payload['success'] ?? false) !== true) {
                return $this->unknownLocation();
            }

            return [
                'country' => $payload['country'] ?? 'Unknown',
                'city' => $payload['city'] ?? 'Unknown',
            ];
        } catch (\Throwable) {
            return $this->unknownLocation();
        }
    }

    private function isLocalOrPrivateIp(string $ip): bool
    {
        if (in_array($ip, ['127.0.0.1', '::1'], true)) {
            return true;
        }

        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }

    private function unknownLocation(): array
    {
        return [
            'country' => 'Unknown',
            'city' => 'Unknown',
        ];
    }
}
