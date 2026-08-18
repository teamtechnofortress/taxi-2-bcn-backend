<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\FetchLocationIqAutocompleteJob;
use App\Services\Location\LocationAutocompleteService;
use App\Services\Location\LocationCacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    public function autocomplete(
        Request $request,
        LocationCacheService $cache,
        LocationAutocompleteService $locationService
    ) {
        $rawKeyword = $request->keyword;

        Log::info('Autocomplete request received', [
            'keyword' => $rawKeyword,
        ]);

        if (! $rawKeyword) {
            return response()->json([
                'status' => 'error',
                'message' => 'keyword is required',
            ], 422);
        }

        /**
         * Normalize keyword
         */
        $keyword = $locationService->normalize($rawKeyword);

        Log::info('Keyword normalized', [
            'original' => $rawKeyword,
            'normalized' => $keyword,
        ]);

        /**
         * Find existing search
         */
        $search = $cache->findSearch($keyword);

        Log::info('Search lookup result', [
            'keyword' => $keyword,
            'found' => (bool) $search,
            'search_id' => $search?->id,
            'status' => $search?->status ?? null,
        ]);

        /**
         * CASE 1: Completed → return cached results
         */
        if ($search && $search->status === 'completed') {

            Log::info('Returning cached completed results', [
                'search_id' => $search->id,
            ]);

            return response()->json([
                'status' => 'completed',
                'results' => $cache->getResults($search->id),
            ]);
        }

        /**
         * CASE 2: Pending → keep polling without duplicating jobs.
         */
        if ($search && $search->status === 'pending') {
            $retryAfterSeconds = (int) config(
                'locationiq.pending_retry_after_seconds',
                60
            );

            $isStuck = $search->updated_at
                && $search->updated_at->lt(
                    now()->subSeconds($retryAfterSeconds)
                );

            if ($isStuck) {
                Log::warning('Re-dispatching stale pending search', [
                    'search_id' => $search->id,
                    'retry_after_seconds' => $retryAfterSeconds,
                ]);

                $cache->markPending($search->id);

                FetchLocationIqAutocompleteJob::dispatch(
                    $search->id,
                    $keyword
                );
            }

            return response()->json([
                'status' => 'pending',
            ]);
        }

        /**
         * CASE 3: Failed → re-trigger job safely.
         */
        if ($search && $search->status === 'failed') {

            Log::info('Re-dispatching job for search', [
                'search_id' => $search->id,
                'status' => $search->status,
            ]);

            $cache->markPending($search->id);

            FetchLocationIqAutocompleteJob::dispatch(
                $search->id,
                $keyword
            );

            return response()->json([
                'status' => 'pending',
            ]);
        }

        /**
         * CASE 4: No cache → create + dispatch
         */
        Log::info('Creating new search record', [
            'keyword' => $keyword,
        ]);

        $search = $cache->createSearch($keyword);

        Log::info('Search created', [
            'search_id' => $search->id,
        ]);

        FetchLocationIqAutocompleteJob::dispatch(
            $search->id,
            $keyword
        );

        Log::info('Job dispatched', [
            'search_id' => $search->id,
            'keyword' => $keyword,
        ]);

        return response()->json([
            'status' => 'pending',
        ]);
    }
}
