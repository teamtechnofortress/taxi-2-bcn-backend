<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Location\LocationCacheService;
use App\Services\Location\LocationAutocompleteService;
use App\Jobs\FetchLocationIqAutocompleteJob;

class LocationController extends Controller
{
    public function autocomplete(
        Request $request,
        LocationCacheService $cache,
        LocationAutocompleteService $locationService
    ) {

        Log::info('Autocomplete request received', [
            'keyword' => $request->keyword
        ]);

        $keyword = $locationService->normalize(
            $request->keyword
        );

        Log::info('Keyword normalized', [
            'original' => $request->keyword,
            'normalized' => $keyword
        ]);

        $search = $cache->findSearch($keyword);

        Log::info('Search lookup result', [
            'keyword' => $keyword,
            'found' => (bool) $search,
            'search_id' => $search?->id,
            'status' => $search?->status
        ]);

        /**
         *  CASE 1: Completed → return cached results
         */
        if ($search && $search->status === 'completed') {

            Log::info('Returning completed results', [
                'search_id' => $search->id
            ]);

            return response()->json([
                'status' => 'completed',
                'results' => $cache->getResults($search->id)
            ]);
        }
        
        /**
         *  CASE 2: Pending OR failed OR stuck → re-trigger job
         */
       if ($search && $search->status === 'pending') {

    Log::info('Search already pending, not re-dispatching', [
        'search_id' => $search->id
    ]);

    return response()->json([
        'status' => 'pending'
    ]);
}

        /**
         *  CASE 3: No cache at all → create + dispatch job
         */
        Log::info('BEFORE CREATE SEARCH', [
    'keyword' => $keyword
]);

        $search = $cache->createSearch($keyword);

        Log::info('AFTER CREATE SEARCH', [
    'search_id' => $search->id
]);

        FetchLocationIqAutocompleteJob::dispatch(
            $search->id,
            $keyword
        );

        Log::info('Autocomplete job dispatched', [
            'search_id' => $search->id,
            'keyword' => $keyword
        ]);

        return response()->json([
            'status' => 'pending'
        ]);
    }
}
