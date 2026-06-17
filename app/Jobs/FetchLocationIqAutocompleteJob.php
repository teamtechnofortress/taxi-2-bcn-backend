<?php

namespace App\Jobs;

use App\Services\Location\LocationIQService;
use App\Services\Location\LocationCacheService;
use App\Services\Location\LocationAutocompleteService;
use App\Services\Location\LocationRateLimiter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class FetchLocationIqAutocompleteJob implements ShouldQueue
{
    use Queueable;

    protected int $searchId;
    protected string $keyword;

    public function __construct(int $searchId, string $keyword)
    {
        $this->searchId = $searchId;
        $this->keyword = $keyword;
    }

    public function handle(
        LocationIQService $locationIQ,
        LocationCacheService $cache,
        LocationAutocompleteService $service,
        LocationRateLimiter $rateLimiter
    ): void {

        // $cache->markProcessing($this->searchId);

        try {
            Log::info('LocationIQ Job started', [
                'search_id' => $this->searchId,
                'keyword' => $this->keyword,
            ]);

            /*
             * STEP 1: API CALL
             */
            $results = $locationIQ->autocomplete($this->keyword);

            Log::info('LocationIQ raw response', [
                'search_id' => $this->searchId,
                'type' => gettype($results),
            ]);
            Log::info('LocationIQ raw response', [
    'search_id' => $this->searchId,
    'type' => gettype($results),
    'response' => $results, // 👈 ADD THIS
]);

            if (!is_array($results)) {
                throw new \Exception('Invalid API response from LocationIQ');
            }
$filtered = $service->filterBarcelona($results) ?? [];
$filtered = array_slice($filtered, 0, 8);

            /*
             * STEP 3: LIMIT RESULTS (safe fallback)
             */
            $filtered = array_slice($filtered, 0, 8);

            /*
             * STEP 4: SAVE RESULTS
             */
            $cache->saveResults($this->searchId, $filtered);

            /*
             * STEP 5: RATE LIMIT TRACKING
             */
            $rateLimiter->attempt();

            /*
             * STEP 6: MARK COMPLETE
             */
            $cache->markCompleted($this->searchId);

            Log::info('LocationIQ Job completed', [
                'search_id' => $this->searchId,
            ]);

        } catch (\Throwable $e) {

            Log::error('LocationIQ Job failed', [
                'search_id' => $this->searchId,
                'message' => $e->getMessage(),
            ]);

            $cache->markFailed($this->searchId);
        }
    }
}