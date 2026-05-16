<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ChatbotController;

// ── Auth API ──────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthApiController::class, 'register'])->name('api.register');
    Route::post('/login',    [AuthApiController::class, 'login'])->name('api.login');

    // Protégé par Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthApiController::class, 'logout'])->name('api.logout');
        Route::get('/me',      [AuthApiController::class, 'me'])->name('api.me');
    });
});

