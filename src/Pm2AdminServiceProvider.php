<?php

declare(strict_types=1);

namespace Faustoff\LaravelPm2Admin;

use Illuminate\Support\ServiceProvider;

class Pm2AdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/pm2-admin.php', 'pm2-admin'
        );
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'pm2-admin');

        $this->publishes([
            __DIR__.'/../config/pm2-admin.php' => config_path('pm2-admin.php'),
        ], 'pm2-admin-config');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/pm2-admin'),
        ], 'pm2-admin-assets');
    }
}