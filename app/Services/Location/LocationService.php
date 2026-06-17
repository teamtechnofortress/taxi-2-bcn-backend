<?php

namespace App\Services\Location;

class LocationService
{
    protected $locationIQ;

    protected $cache;

    public function __construct(
        LocationIQService $locationIQ,
        LocationCacheService $cache
    ) {
        $this->locationIQ = $locationIQ;

        $this->cache = $cache;
    }

    public function normalize(
        string $keyword
    ): string {

        return strtolower(
            trim($keyword)
        );
    }

//     public function filterBarcelona(
//         array $results
//     ): array {
//          \Log::info('LocationIQ Results', [
//     'count' => count($results)
// ]);

//         $allowedCities = config(
//             'locationiq.allowed_cities'
//         );

//         $filtered = [];

//         foreach ($results as $item) {

//             $city = strtolower(

//                 $item['address']['city']
//                 ?? $item['address']['town']
//                 ?? $item['address']['municipality']
//                 ?? ''
//             );

//             if (
//                 !in_array(
//                     $city,
//                     $allowedCities
//                 )
//             ) {
//                 continue;
//             }

//             $filtered[] = [

//                 'place_id' =>
//                     $item['place_id'] ?? null,

//                 'display_name' =>
//                     $item['display_name'] ?? null,

//                 'lat' =>
//                     $item['lat'] ?? null,

//                 'lon' =>
//                     $item['lon'] ?? null,

//                 'city' => $city,
//             ];
//         }

//         return $filtered;
//     }
}
