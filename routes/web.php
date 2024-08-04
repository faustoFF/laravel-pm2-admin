<?php

use Faustoff\LaravelPm2Admin\Http\Controllers\ApiController;
use Faustoff\LaravelPm2Admin\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::prefix('pm2')
    ->middleware(config('pm2-admin.middleware'))
    ->group(function () {
        Route::get('api', ApiController::class);
        Route::get('', WebController::class);
    })
;