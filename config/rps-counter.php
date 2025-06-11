<?php

return [
    'redis_key' => env('RPS_COUNTER_REDIS_KEY', 'settings:rps_count'),
    'redis_prefix' => env('AUTH_REDIS_PREFIX', 'laravel_database_')
];