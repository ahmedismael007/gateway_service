<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\DiscountController;
use App\Http\Controllers\v1\FeatureController;
use App\Http\Controllers\v1\PlanController;
use App\Http\Controllers\v1\PrivilegeController;
use App\Http\Controllers\v1\TenantController;
use App\Http\Controllers\v1\ThemeController;
use App\Http\Controllers\v1\UserController;
use App\Http\Middleware\InitializeTenantFromHeader;
use App\Http\Middleware\SetLocaleFromHeader;
use App\Http\Services\v1\Kafka\KafkaProducerService;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware([
    'api',
    SetLocaleFromHeader::class,
    InitializeTenantFromHeader::class,
])->group(function () {
    // Authentication
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::apiResource('tenants', TenantController::class)->only('index', 'show');

    Route::apiResource('plans', PlanController::class)->only('index');

    Route::apiResource('features', FeatureController::class)->only('index');

    Route::apiResource('privileges', PrivilegeController::class)->only('index');

    Route::apiResource('discounts', DiscountController::class)->only('index');

    Route::apiResource('themes', ThemeController::class)->only('index');

    Route::middleware('auth:api')->group(function () {
        Route::delete('users', [UserController::class, 'destroy_bulk']);

        Route::post('users/email-confirmation', [AuthController::class, 'confirm_email']);
        Route::get('users/send-confirmation-email', [AuthController::class, 'send_confirmation_email']);
        Route::apiResource('users', UserController::class);

        Route::apiResource('tenants', TenantController::class)->except('index', 'show');

        Route::delete('tenants', [TenantController::class, 'destroy_bulk']);

        Route::apiResource('plans', PlanController::class)->except('index');

        Route::apiResource('features', FeatureController::class)->except('index');

        Route::apiResource('privileges', PrivilegeController::class)->except('index');

        Route::apiResource('discounts', DiscountController::class)->except('index');
        Route::delete('discounts', [DiscountController::class, 'destroy_bulk']);

        Route::apiResource('themes', ThemeController::class)->except('index');

        Route::get('logout', [AuthController::class, 'logout']);
    });
});
