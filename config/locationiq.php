<?php

return [

    'api_key' => env('LOCATIONIQ_KEY'),

    'base_url' => env('LOCATIONIQ_BASE_URL', 'https://api.locationiq.com/v1'),

    'autocomplete_limit' => env('LOCATIONIQ_AUTOCOMPLETE_LIMIT', 10),

    'country_codes' => env('LOCATIONIQ_COUNTRY_CODES', 'es'),

    'requests_per_second' => env('LOCATIONIQ_REQUESTS_PER_SECOND', 2),

    'allowed_cities' => array_map(
        'trim',
        explode(',', env('LOCATIONIQ_ALLOWED_CITIES', ''))
    ),

];