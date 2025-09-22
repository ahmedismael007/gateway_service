<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocaleFromHeader
{
    public function handle(Request $request, Closure $next)
    {
        // Get 'Accept-Language' header (e.g., "en", "ar", etc.)
        $locale = $request->header('Accept-Language');

        // Optionally validate against supported locales
        $supported = ['en', 'ar'];
        if ($locale && in_array($locale, $supported)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
