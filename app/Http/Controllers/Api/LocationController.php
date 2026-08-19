<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Location\LocationAutocompleteService;
use App\Services\Location\LocationCacheService;
use App\Services\Location\LocationIQService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class LocationController extends Controller
{
    public function autocomplete(
        Request $request,
        LocationCacheService $cache,
        LocationAutocompleteService $locationService,
        LocationIQService $locationIQ
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
         * CASE 2: Cache miss / pending / failed → fetch directly when the
         * LocationIQ global rate limit has capacity.
         */
        if (! $search) {
            Log::info('Creating new search record', [
                'keyword' => $keyword,
            ]);

            $search = $cache->createSearch($keyword);

            Log::info('Search created', [
                'search_id' => $search->id,
            ]);
        } elseif ($search->status === 'failed') {
            $cache->markPending($search->id);
        }

        $lock = Cache::lock(
            'locationiq_autocomplete:'.sha1($keyword),
            10
        );

        if (! $lock->get()) {
            Log::info('Autocomplete fetch already running for keyword', [
                'keyword' => $keyword,
                'search_id' => $search->id,
            ]);

            return response()->json([
                'status' => 'pending',
                'retry_after' => 1,
            ], 202);
        }

        try {
            $search = $cache->findSearch($keyword);

            if ($search && $search->status === 'completed') {
                Log::info('Returning cached completed results after lock', [
                    'search_id' => $search->id,
                ]);

                return response()->json([
                    'status' => 'completed',
                    'results' => $cache->getResults($search->id),
                ]);
            }

            $maxAttempts = max(
                1,
                (int) config('locationiq.rate_limit_max_attempts', 2)
            );

            $decaySeconds = max(
                1,
                (int) config('locationiq.rate_limit_decay_seconds', 1)
            );

            $rateLimitLock = Cache::lock(
                'locationiq_global_rate_limit_lock',
                2
            );

            if (! $rateLimitLock->get()) {
                return response()->json([
                    'status' => 'pending',
                    'retry_after' => 1,
                ], 202);
            }

            try {
                if (RateLimiter::tooManyAttempts('locationiq:global', $maxAttempts)) {
                    $retryAfter = max(
                        1,
                        RateLimiter::availableIn('locationiq:global')
                    );

                    Log::info('LocationIQ rate limit reached', [
                        'keyword' => $keyword,
                        'search_id' => $search->id,
                        'retry_after' => $retryAfter,
                    ]);

                    return response()->json([
                        'status' => 'pending',
                        'retry_after' => $retryAfter,
                    ], 429);
                }

                RateLimiter::hit('locationiq:global', $decaySeconds);
            } finally {
                $rateLimitLock->release();
            }

            Log::info('Calling LocationIQ directly for autocomplete', [
                'keyword' => $keyword,
                'search_id' => $search->id,
            ]);

            $results = $locationIQ->autocomplete($keyword);

            if (! is_array($results)) {
                throw new \Exception('Invalid API response from LocationIQ');
            }

            $limitedResults = array_slice($results, 0, 8);

            $cache->saveResults($search->id, $limitedResults);
            $cache->markCompleted($search->id);

            Log::info('LocationIQ autocomplete completed directly', [
                'keyword' => $keyword,
                'search_id' => $search->id,
                'count' => count($limitedResults),
            ]);

            return response()->json([
                'status' => 'completed',
                'results' => $cache->getResults($search->id),
            ]);
        } catch (\Throwable $e) {
            Log::error('Direct LocationIQ autocomplete failed', [
                'keyword' => $keyword,
                'search_id' => $search?->id,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            if ($search) {
                $cache->markFailed($search->id);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Unable to fetch autocomplete results',
            ], 502);
        } finally {
            optional($lock)->release();
        }
    }
}
