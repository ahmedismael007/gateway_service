<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyRequest
{
public function handle(Request $request, Closure $next, string $serviceUrl)
{
 // Collect and filter headers
$headers = collect($request->headers->all())
->except(['host', 'content-length', 'cookie'])
->map(fn($values) => $values[0] ?? '')
->toArray();

     

// Prepare options depending on request type
$options = ['query' => $request->query()];

if ($request->isJson()) {
$options['json'] = $request->json()->all();
} elseif (str_starts_with($request->header('Content-Type', ''), 'multipart/form-data')) {
$options['multipart'] = collect($request->allFiles())->map(function ($file, $key) {
return [
'name' => $key,
'contents' => fopen($file->getRealPath(), 'r'),
'filename' => $file->getClientOriginalName(),
];
})->values()->all();

foreach ($request->except(array_keys($request->allFiles())) as $key => $value) {
$options['multipart'][] = [
'name' => $key,
'contents' => $value,
];
}
} else {
$options['form_params'] = $request->all();
}

// 👇 get the path captured by the route
$proxiedPath = $request->route('path') ?? '';
$url = rtrim($serviceUrl, '/') . '/' . ltrim($proxiedPath, '/');

// Forward request to service
$response = Http::withHeaders($headers)
->send($request->method(), $url, $options);

// Return service response
return response($response->body(), $response->status())
->withHeaders(
collect($response->headers())
->except(['transfer-encoding', 'content-encoding', 'content-length'])
->toArray()
);
}
}