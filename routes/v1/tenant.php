<?php

declare(strict_types=1);

use App\Http\Middleware\InitializeTenantFromHeader;
use App\Http\Middleware\ProxyRequest;
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

Route::prefix('api/v1')->middleware('api')->middleware(InitializeTenantFromHeader::class)->group(function () {
    Route::any('accounting/{path?}', fn() => null)
        ->where('path', '.*')
        ->middleware([ProxyRequest::class . ':http://accounting_web/api/v1']);

    Route::any('project-management/{path?}', fn() => null)
        ->where('path', '.*')
        ->middleware([ProxyRequest::class . ':http://project_management_web/api/v1']);

    Route::any('hr/{path?}', fn() => null)
        ->where('path', '.*')
        ->middleware([ProxyRequest::class . ':http://hr_web/api/v1']);
});
