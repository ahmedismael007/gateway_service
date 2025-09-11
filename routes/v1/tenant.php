<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::prefix('api/v1')->middleware('api')->middleware(\App\Http\Middleware\InitializeTenantFromHeader::class)->group(function () {
    Route::any('/accounting/{path}', function (\Illuminate\Http\Request $request, $path) {
        // 🟢 Prepare headers (filter out problematic ones)
        $headers = collect($request->headers->all())
            ->except(['host', 'content-length'])
            ->map(fn($values) => $values[0] ?? '')
            ->toArray();

        // 🟢 Prepare request options (query + body depending on content type)
        $options = [
            'query' => $request->query(),
        ];

        if ($request->isJson()) {
            $options['json'] = $request->json()->all();
        } elseif (str_starts_with($request->header('Content-Type', ''), 'multipart/form-data')) {
            $options['multipart'] = collect($request->allFiles())->map(function ($file, $key) {
                return [
                    'name'     => $key,
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                ];
            })->values()->all();

            // add normal fields too
            foreach ($request->except(array_keys($request->allFiles())) as $key => $value) {
                $options['multipart'][] = [
                    'name'     => $key,
                    'contents' => $value,
                ];
            }
        } else {
            $options['form_params'] = $request->all();
        }

        // 🟢 Forward request to accounting service
        $response = Http::withHeaders($headers)
            ->send($request->method(), "http://nginx_accounting/api/v1/$path", $options);

        // 🟢 Return response safely (remove encoding/length headers)
        return response($response->body(), $response->status())
            ->withHeaders(collect($response->headers())
                ->except(['transfer-encoding', 'content-encoding', 'content-length'])
                ->toArray()
            );
    })->where('path', '.*');
});
