<?php

namespace App\Services\Location;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LocationIQService
{
    public function autocomplete(string $keyword): array
    {
        $url = config('locationiq.base_url') . '/autocomplete.php';

        $payload = [
            'key' => config('locationiq.api_key'),
            'q' => $keyword,
            'format' => 'json',
            'limit' => config('locationiq.autocomplete_limit'),
            'countrycodes' => config('locationiq.country_codes'),
        ];

        Log::info('LocationIQ REQUEST', [
            'url' => $url,
            'keyword' => $keyword,
            'payload' => $payload,
        ]);

        $response = Http::get($url, $payload);

        Log::info('LocationIQ RESPONSE STATUS', [
            'status' => $response->status(),
            'ok' => $response->successful(),
        ]);

        Log::info('LocationIQ RAW BODY', [
            'body' => $response->body(),
        ]);

        // Detect non-JSON / API failure responses
        if (!$response->successful()) {
            Log::error('LocationIQ HTTP ERROR', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [];
        }

        $json = $response->json();

        Log::info('LocationIQ PARSED JSON TYPE', [
            'type' => gettype($json),
            'is_array' => is_array($json),
        ]);

        if (!is_array($json)) {
            Log::warning('LocationIQ INVALID JSON FORMAT', [
                'json' => $json,
            ]);

            return [];
        }

        return $json;
    }
}