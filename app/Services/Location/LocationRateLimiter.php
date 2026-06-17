<?php

namespace App\Services\Location;

use Illuminate\Support\Facades\Cache;

class LocationRateLimiter
{
    private int $maxPerSecond = 2;

    private string $key = 'locationiq_rate_limit';

    public function attempt(): void
    {
        $window = now()->format('Y-m-d H:i:s'); 
        // second-level window

        $cacheKey = $this->key . ':' . $window;

        $count = Cache::increment($cacheKey);

        if ($count == 1) {
            Cache::expire($cacheKey, 2);
        }

        if ($count > $this->maxPerSecond) {

            usleep(500000); // 0.5 sec

            $this->attempt();
        }
    }
}


