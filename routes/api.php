<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\PageController;

Route::prefix('v1')->middleware('api.key')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Guest Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/verify-email-otp', [AuthController::class, 'verifyEmailOtp']);
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    });

    /*
    |--------------------------------------------------------------------------
    | Authenticated Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);

        // Staff Profile APIs
        Route::post('/profile/update', [AuthController::class, 'updateProfile']);
        Route::post('/profile/change-password', [AuthController::class, 'changePassword']);
        Route::post('/profile/update-image', [AuthController::class, 'updateProfileImage']);
    });

    /*
    |--------------------------------------------------------------------------
    | Pages Routes (Public)
    |--------------------------------------------------------------------------
    */
    Route::prefix('pages')->group(function () {
        Route::get('/', [PageController::class, 'index']);
        Route::get('/{slug}', [PageController::class, 'showBySlug']);
    });

    // Categories
    Route::get('/categories', [HomeController::class, 'categories']);
    // Home
    Route::get('/home', [HomeController::class, 'index']);
});
