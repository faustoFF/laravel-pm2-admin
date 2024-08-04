<?php

declare(strict_types=1);

namespace Faustoff\LaravelPm2Admin\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class WebController extends Controller
{
    public function __invoke(): View
    {
        return view('pm2-admin::index');
    }
}