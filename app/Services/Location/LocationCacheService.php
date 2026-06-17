<?php

namespace App\Services\Location;

use App\Models\AutocompleteSearch;
use App\Models\AutocompleteResult;

class LocationCacheService
{
    public function findSearch(string $keyword)
    {
        return AutocompleteSearch::where(
            'keyword',
            $keyword
        )->first();
    }

    public function createSearch(string $keyword)
{
    return AutocompleteSearch::firstOrCreate(
        ['keyword' => $keyword],
        ['status' => 'pending']
    );
}

    public function getResults(int $searchId)
    {
        return AutocompleteResult::where(
            'search_id',
            $searchId
        )
        ->limit(8)
        ->get();
    }

    public function saveResults(
        int $searchId,
        array $results
    ) {
        foreach ($results as $result) {

            AutocompleteResult::create([

                'search_id' => $searchId,

                'place_id' => $result['place_id'],

                'display_name' => $result['display_name'],

                'city' => $result['city'],

                'lat' => $result['lat'],

                'lon' => $result['lon'],
            ]);
        }
    }

    public function markCompleted(int $searchId)
    {
        AutocompleteSearch::where(
            'id',
            $searchId
        )->update([
            'status' => 'completed'
        ]);
    }
    public function markFailed(int $searchId)
    {
        AutocompleteSearch::where(
            'id',
            $searchId
        )->update([
            'status' => 'failed'
        ]);
    }
}