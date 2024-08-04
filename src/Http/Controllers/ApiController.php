<?php

declare(strict_types=1);

namespace Faustoff\LaravelPm2Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class ApiController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'method' => [
                'required',
                Rule::in(['list', 'start', 'stop', 'restart']),
            ],
            'process' => [
                'string',
            ],
        ]);

        $response = Http::get(
            config('pm2-admin.api_server_address'),
            $validated
        );

        return $response->ok()
            ? new JsonResponse(['data' => $response->json()])
            : new JsonResponse($response->json(), 400)
        ;
    }
}
