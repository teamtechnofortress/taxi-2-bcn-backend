<?php

namespace App\Services\Location;

use Illuminate\Support\Facades\Http;

class LocationReverseGeocodingService
{
    public function getAddress($lat, $lng)
    {
        $response = Http::get('https://us1.locationiq.com/v1/reverse.php', [
            'key' => config('locationiq.api_key'),
            'lat' => $lat,
            'lon' => $lng,
            'format' => 'json'
        ]);

        if (!$response->successful()) {
            return null;
        }

        return $response->json();
    }

    public function getCity($lat, $lng)
    {
        $data = $this->getAddress($lat, $lng);

        return $data['address']['city']
            ?? $data['address']['town']
            ?? $data['address']['county']
            ?? null;
    }
}