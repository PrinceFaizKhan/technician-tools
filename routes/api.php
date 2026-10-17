<?php

use App\Http\Controllers\Api\ApplianceController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CompressorController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ErrorCodeController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RefrigerantController;
use App\Http\Controllers\Api\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Modern RESTful API (v1)
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function (): void {
    // Authentication
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
    });

    // Appliances & Brands
    Route::get('/appliances', [ApplianceController::class, 'index']);
    Route::get('/appliances/{id}', [ApplianceController::class, 'show']);
    Route::get('/brands', [BrandController::class, 'index']);
    Route::get('/brands/{id}', [BrandController::class, 'show']);

    // Error Codes
    Route::get('/error-codes', [ErrorCodeController::class, 'index']);
    Route::get('/error-codes/{id}', [ErrorCodeController::class, 'show']);

    // Technical Reference: Refrigerants & Compressors
    Route::get('/refrigerants', [RefrigerantController::class, 'index']);
    Route::get('/refrigerants/{id}', [RefrigerantController::class, 'show']);
    Route::get('/compressors', [CompressorController::class, 'index']);
    Route::get('/compressors/{id}', [CompressorController::class, 'show']);

    // Products & E-Commerce Spares
    Route::get('/products/categories', [ProductController::class, 'categories']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);

    // Training Courses & Videos
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);

    // Technical Articles & Guides
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{id}', [ArticleController::class, 'show']);

    // Banners & App Settings
    Route::get('/banners', [BannerController::class, 'index']);
    Route::get('/settings', [SettingController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| Legacy Compatible Aliases (Allows direct migration of legacy clients)
|--------------------------------------------------------------------------
*/
Route::post('/login-admin', [AuthController::class, 'login']);
Route::get('/get-all-appliance-error-code-list', [ApplianceController::class, 'index']);
Route::get('/get-all-brand-name-error-code-list', [BrandController::class, 'index']);
Route::get('/get-all-error-codes-list', [ErrorCodeController::class, 'index']);
Route::get('/get-all-refrigerant', [RefrigerantController::class, 'index']);
Route::get('/get-all-compressor', [CompressorController::class, 'index']);
Route::get('/get-all-products', [ProductController::class, 'index']);
Route::get('/get-all-course-list', [CourseController::class, 'index']);
Route::get('/get-all-articals', [ArticleController::class, 'index']);
Route::get('/get-all-banner', [BannerController::class, 'index']);
