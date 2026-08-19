<?php

return [

    'api_key' => env('LOCATIONIQ_KEY'),

    'base_url' => env('LOCATIONIQ_BASE_URL', 'https://api.locationiq.com/v1'),

    'autocomplete_limit' => env('LOCATIONIQ_AUTOCOMPLETE_LIMIT', 10),

    'country_codes' => env('LOCATIONIQ_COUNTRY_CODES', 'es'),

    'requests_per_second' => env('LOCATIONIQ_REQUESTS_PER_SECOND', 2),

    'rate_limit_max_attempts' => env(
        'LOCATIONIQ_RATE_LIMIT_MAX_ATTEMPTS',
        env('LOCATIONIQ_REQUESTS_PER_SECOND', 2)
    ),

    'rate_limit_decay_seconds' => env(
        'LOCATIONIQ_RATE_LIMIT_DECAY_SECONDS',
        1
    ),

    'rate_limit_release_after' => env(
        'LOCATIONIQ_RATE_LIMIT_RELEASE_AFTER',
        1
    ),

    'pending_retry_after_seconds' => env(
        'LOCATIONIQ_PENDING_RETRY_AFTER_SECONDS',
        60
    ),

    'allowed_cities' => array_map(
        'trim',
        explode(',', env('LOCATIONIQ_ALLOWED_CITIES', ''))
    ),

];
