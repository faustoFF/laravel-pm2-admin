<?php

use Faustoff\LaravelPm2Admin\Http\Middleware\Authorize;

return [
    'api_server_address' => env('PM2_ADMIN_API_SERVER_ADDRESS', 'pm2:8000'),

    'middleware' => [
        'web',
        Authorize::class,
    ]
];