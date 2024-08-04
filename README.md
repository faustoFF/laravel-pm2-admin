# laravel-pm2-admin

> Provides dashboard to manage PM2 applications such as start/restart/stop/list.

`composer require faustoff/laravel-pm2-admin`

Publish `assets`:

`php artisan vendor:publish --tag=pm2-admin-assets`

To auto update `assets` on package update add to `composer.json`:

```json
{
    "scripts": {
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=pm2-admin-assets --ansi --force"
        ]
    }
}
```

Publish `config`:

`php artisan vendor:publish --tag=pm2-admin-config`

## Authorization

The PM2 Admin dashboard may be accessed via the `/pm2` route. By default, you will only be able to access this dashboard in the local environment. To access dashboard in the non-local environment you should define `viewPm2Admin` authorization gate in you application service provider, for example:

```php
use Faustoff\LaravelPm2Admin\Http\Middleware\Authorize;

public function boot()
{
    Gate::define(Authorize::ABILITY, function (?User $user) {
        return (bool) $user?->isAdmin;
    });
}
```

## API Server

You should run API server which will process API requests from PM2 Admin dashboard and forward directly to backend pm2 daemon. Example of `ecosystem.config.js`:

```js
module.exports = {
  apps: [
    // your another applications
    {
      name: 'pm2-admin',
      script: 'vendor/faustoff/laravel-pm2-admin/dist/index.js',
      instances: 1,
      exec_mode: 'fork',
    }
  ]
}
```

By default, your application will assume that the API server is accessible by the address `pm2:8000`. This setup corresponds to a situation where your application, API server, and the pm2 daemon are running inside a Docker environment. In this configuration, the pm2 daemon is running inside a Docker container named `pm2`.

You can override API server address which is used by your application to access API server by using `PM2_ADMIN_API_SERVER_ADDRESS` environment variable.