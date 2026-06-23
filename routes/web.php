<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\PencarianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogController;

/*
|--------------------------------------------------------------------------
| Web Routes — Sistem Arsip Digital UKRI
|--------------------------------------------------------------------------
*/

// Auth
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth.session'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dokumen CRUD
    Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen');
    Route::get('/dokumen/create', [DokumenController::class, 'create'])->name('dokumen.create');
    Route::post('/dokumen', [DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('/dokumen/{id}', [DokumenController::class, 'show'])->name('dokumen.show');
    Route::get('/dokumen/{id}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit');
    Route::put('/dokumen/{id}', [DokumenController::class, 'update'])->name('dokumen.update');
    Route::delete('/dokumen/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
    Route::get('/dokumen/{id}/download', [DokumenController::class, 'download'])->name('dokumen.download');
    Route::get('/dokumen/{id}/preview', [DokumenController::class, 'preview'])->name('dokumen.preview');

    // Foto CRUD
    Route::get('/foto', [FotoController::class, 'index'])->name('foto');
    Route::get('/foto/create', [FotoController::class, 'create'])->name('foto.create');
    Route::post('/foto', [FotoController::class, 'store'])->name('foto.store');
    Route::get('/foto/{id}', [FotoController::class, 'show'])->name('foto.show');
    Route::get('/foto/{id}/edit', [FotoController::class, 'edit'])->name('foto.edit');
    Route::put('/foto/{id}', [FotoController::class, 'update'])->name('foto.update');
    Route::delete('/foto/{id}', [FotoController::class, 'destroy'])->name('foto.destroy');

    // Video CRUD
    Route::get('/video', [VideoController::class, 'index'])->name('video');
    Route::get('/video/create', [VideoController::class, 'create'])->name('video.create');
    Route::post('/video', [VideoController::class, 'store'])->name('video.store');
    Route::get('/video/{id}', [VideoController::class, 'show'])->name('video.show');
    Route::get('/video/{id}/edit', [VideoController::class, 'edit'])->name('video.edit');
    Route::put('/video/{id}', [VideoController::class, 'update'])->name('video.update');
    Route::delete('/video/{id}', [VideoController::class, 'destroy'])->name('video.destroy');

    // Link CRUD
    Route::get('/link', [LinkController::class, 'index'])->name('link');
    Route::get('/link/create', [LinkController::class, 'create'])->name('link.create');
    Route::post('/link', [LinkController::class, 'store'])->name('link.store');
    Route::get('/link/{id}', [LinkController::class, 'show'])->name('link.show');
    Route::get('/link/{id}/edit', [LinkController::class, 'edit'])->name('link.edit');
    Route::put('/link/{id}', [LinkController::class, 'update'])->name('link.update');
    Route::delete('/link/{id}', [LinkController::class, 'destroy'])->name('link.destroy');

    // Pencarian
    Route::get('/pencarian', [PencarianController::class, 'index'])->name('pencarian');

    // Admin only
    Route::middleware(['role.admin'])->group(function () {
        // User Management CRUD
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

        // Log Aktivitas
        Route::get('/log', [LogController::class, 'index'])->name('log');
        Route::get('/log/export', [LogController::class, 'export'])->name('log.export');
    });
});
