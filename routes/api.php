<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\DokumenApiController;
use App\Http\Controllers\Api\FotoApiController;
use App\Http\Controllers\Api\VideoApiController;
use App\Http\Controllers\Api\LinkApiController;
use App\Http\Controllers\Api\UserApiController;

/*
|--------------------------------------------------------------------------
| API Routes — Sistem Arsip Digital UKRI
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Auth Routes
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/forgot-password', [AuthApiController::class, 'forgotPassword']);

// Health check endpoint
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'message' => 'API is running']);
});

// Protected Routes (Require Auth Token)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/me', [AuthApiController::class, 'me']);
    Route::put('/profile', [AuthApiController::class, 'updateProfile']);
    Route::post('/change-password', [AuthApiController::class, 'changePassword']);

    // Dokumen
    Route::apiResource('dokumen', DokumenApiController::class);
    Route::post('/dokumen/{id}/download', [DokumenApiController::class, 'download']);
    Route::get('/dokumen/search/{query}', [DokumenApiController::class, 'search']);

    // Foto
    Route::apiResource('foto', FotoApiController::class);
    Route::get('/foto/search/{query}', [FotoApiController::class, 'search']);

    // Video
    Route::apiResource('video', VideoApiController::class);
    Route::get('/video/search/{query}', [VideoApiController::class, 'search']);

    // Link
    Route::apiResource('link', LinkApiController::class);
    Route::get('/link/search/{query}', [LinkApiController::class, 'search']);
    Route::get('/link/category/{category}', [LinkApiController::class, 'getByCategory']);

    // Admin Only Routes
    Route::middleware('admin')->group(function () {
        Route::apiResource('users', UserApiController::class);
        Route::post('/users/{id}/toggle-status', [UserApiController::class, 'toggleStatus']);
        Route::get('/users/{id}/activity', [UserApiController::class, 'getActivity']);
    });
});
