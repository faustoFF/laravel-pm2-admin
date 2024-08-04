<?php

use Faustoff\LaravelPm2Admin\Http\Controllers\ApiController;
use Faustoff\LaravelPm2Admin\Http\Controllers\WebController;
use Faustoff\LaravelPm2Admin\Http\Middleware\Authorize;
use Illuminate\Support\Facades\Route;

Route::prefix('pm2')
    ->middleware([
        'web',
        Authorize::class,
    ])
    ->group(function () {
        Route::get('api', ApiController::class);
        Route::get('', WebController::class);
    })
;