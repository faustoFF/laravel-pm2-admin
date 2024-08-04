<?php

declare(strict_types=1);

namespace Faustoff\LaravelPm2Admin\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    public const ABILITY = 'viewPm2Admin';

    public function handle(Request $request, \Closure $next): Response
    {
        if (!App::isLocal()) {
            Gate::authorize(self::ABILITY);
        }

        return $next($request);
    }
}