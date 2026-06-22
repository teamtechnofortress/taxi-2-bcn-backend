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
        $rawKeyword = $request->keyword;

        Log::info('Autocomplete request received', [
            'keyword' => $rawKeyword
        ]);

        if (!$rawKeyword) {
            return response()->json([
                'status' => 'error',
                'message' => 'keyword is required'
            ], 422);
        }

        /**
         * Normalize keyword
         */
        $keyword = $locationService->normalize($rawKeyword);

        Log::info('Keyword normalized', [
            'original' => $rawKeyword,
            'normalized' => $keyword
        ]);

        /**
         * Find existing search
         */
        $search = $cache->findSearch($keyword);

        Log::info('Search lookup result', [
            'keyword' => $keyword,
            'found' => (bool) $search,
            'search_id' => $search?->id,
            'status' => $search?->status ?? null
        ]);

        /**
         * CASE 1: Completed → return cached results
         */
        if ($search && $search->status === 'completed') {

            Log::info('Returning cached completed results', [
                'search_id' => $search->id
            ]);

            return response()->json([
                'status' => 'completed',
                'results' => $cache->getResults($search->id)
            ]);
        }

        /**
         * CASE 2: Pending / Failed / Stuck → re-trigger job safely
         */
        if ($search && in_array($search->status, ['pending', 'failed'])) {

            Log::info('Re-dispatching job for search', [
                'search_id' => $search->id,
                'status' => $search->status
            ]);

            FetchLocationIqAutocompleteJob::dispatch(
                $search->id,
                $keyword
            );

            return response()->json([
                'status' => 'pending'
            ]);
        }

        /**
         * CASE 3: No cache → create + dispatch
         */
        Log::info('Creating new search record', [
            'keyword' => $keyword
        ]);

        $search = $cache->createSearch($keyword);

        Log::info('Search created', [
            'search_id' => $search->id
        ]);

        FetchLocationIqAutocompleteJob::dispatch(
            $search->id,
            $keyword
        );

        Log::info('Job dispatched', [
            'search_id' => $search->id,
            'keyword' => $keyword
        ]);

        return response()->json([
            'status' => 'pending'
        ]);
    }
}