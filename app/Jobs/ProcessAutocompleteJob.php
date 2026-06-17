<?php

namespace App\Jobs;

use App\Models\AutocompleteSearch;
use App\Models\AutocompleteResult;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class ProcessAutocompleteJob implements ShouldQueue
{
    use Queueable;

    protected $searchId;

    public function __construct($searchId)
    {
        $this->searchId = $searchId;
    }

    public function handle(): void
    {
        $search = AutocompleteSearch::find(
            $this->searchId
        );

        if (!$search) {
            return;
        }

        sleep(1);

        /*
        |--------------------------------------------------------------------------
        | LOCATION IQ API
        |--------------------------------------------------------------------------
        */

        $response = Http::get(
            'https://api.locationiq.com/v1/autocomplete.php',
            [
                'key' => env('LOCATIONIQ_API_KEY'),

                'q' => $search->keyword,

                'format' => 'json',

                'limit' => 10,

                'countrycodes' => 'es',
            ]
        );

        $results = $response->json();

        /*
        |--------------------------------------------------------------------------
        | ALLOWED BARCELONA CITIES
        |--------------------------------------------------------------------------
        */

        $allowedCities = [

            'barcelona',
            'hospitalet de llobregat',
            'badalona',
            'terrassa',
            'sabadell',
            'mataro',
            'sitges',
            'castelldefels',
            'cornella de llobregat',
            'el prat de llobregat',
        ];

        foreach ($results as $item) {

            $city = strtolower(

                $item['address']['city']
                ?? $item['address']['town']
                ?? $item['address']['municipality']
                ?? ''
            );

            // if (
            //     !in_array(
            //         $city,
            //         $allowedCities
            //     )
            // ) {
            //     continue;
            // }

            AutocompleteResult::create([

                'search_id' => $search->id,

                'place_id' => $item['place_id'] ?? null,

                'display_name' => $item['display_name'] ?? null,

                'lat' => $item['lat'] ?? null,

                'lon' => $item['lon'] ?? null,

                'city' => $city,
            ]);
        }

        $search->update([

            'status' => 'completed'
        ]);
    }
}