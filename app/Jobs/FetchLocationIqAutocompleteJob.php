<?php

namespace App\Jobs;

use App\Services\Location\LocationAutocompleteService;
use App\Services\Location\LocationCacheService;
use App\Services\Location\LocationIQService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Log;

class FetchLocationIqAutocompleteJob implements ShouldQueue
{
    use Queueable;

    protected int $searchId;

    protected string $keyword;

    public int $tries = 0;

    public function __construct(int $searchId, string $keyword)
    {
        $this->searchId = $searchId;
        $this->keyword = $keyword;
    }

    public function middleware(): array
    {
        return [
            (new RateLimited('locationiq'))->releaseAfter(
                (int) config('locationiq.rate_limit_release_after', 1)
            ),
        ];
    }

    public function handle(
        LocationIQService $locationIQ,
        LocationCacheService $cache,
        LocationAutocompleteService $service
    ): void {

        // $cache->markProcessing($this->searchId);

        try {
            Log::info('🚀 LocationIQ Job STARTED', [
                'search_id' => $this->searchId,
                'keyword' => $this->keyword,
            ]);

            /*
             * STEP 1: API CALL
             */
            Log::info('📡 STEP 1: Calling LocationIQ API', [
                'search_id' => $this->searchId,
                'keyword' => $this->keyword,
            ]);

            $results = $locationIQ->autocomplete($this->keyword);

            Log::info('📡 STEP 1 COMPLETE: API response received', [
                'search_id' => $this->searchId,
                'type' => gettype($results),
                'is_array' => is_array($results),
            ]);

            Log::info('📦 RAW API RESPONSE DUMP', [
                'search_id' => $this->searchId,
                'response' => $results,
            ]);

            /*
             * STEP 2: VALIDATION
             */
            Log::info('🔍 STEP 2: Validating response', [
                'search_id' => $this->searchId,
            ]);

            if (! is_array($results)) {
                Log::error('❌ Invalid API response (not array)', [
                    'search_id' => $this->searchId,
                    'response' => $results,
                ]);

                throw new \Exception('Invalid API response from LocationIQ');
            }

            Log::info('✅ STEP 2 COMPLETE: Valid response confirmed', [
                'search_id' => $this->searchId,
                'count' => count($results),
            ]);

            /*
             * STEP 3: FILTERING (currently disabled for debugging)
             */
            Log::info('⚙️ STEP 3: Filtering SKIPPED (debug mode)', [
                'search_id' => $this->searchId,
                'reason' => 'filtering disabled for testing raw API data',
            ]);

            // OPTIONAL FILTER (uncomment when needed)
            // $results = $service->filterLocation($results);

            /*
             * STEP 4: LIMIT RESULTS
             */
            $limitedResults = array_slice($results, 0, 8);

            Log::info('✂️ STEP 4: Results limited', [
                'search_id' => $this->searchId,
                'original_count' => count($results),
                'final_count' => count($limitedResults),
            ]);

            /*
             * STEP 5: SAVE RESULTS
             */
            Log::info('💾 STEP 5: Saving results to cache', [
                'search_id' => $this->searchId,
            ]);

            $cache->saveResults($this->searchId, $limitedResults);

            Log::info(' STEP 5 COMPLETE: Results saved successfully', [
                'search_id' => $this->searchId,
            ]);

            /*
             * STEP 6: MARK COMPLETED
             */
            Log::info('🏁 STEP 6: Marking job as completed', [
                'search_id' => $this->searchId,
            ]);

            $cache->markCompleted($this->searchId);

            Log::info('🎉 LocationIQ Job COMPLETED SUCCESSFULLY', [
                'search_id' => $this->searchId,
            ]);

        } catch (\Throwable $e) {

            Log::error('💥 LocationIQ Job FAILED', [
                'search_id' => $this->searchId,
                'keyword' => $this->keyword,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            $cache->markFailed($this->searchId);
        }
    }
}
