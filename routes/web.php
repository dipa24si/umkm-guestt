<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UlasanProdukController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

// ================== HOME ==================
Route::get('/', function () {
    return view('pages.dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/about', [AboutController::class, 'about'])->name('about');

// ================== WARGA ==================
Route::get('/warga', [WargaController::class, 'index'])->name('warga.index');

Route::middleware('auth')->group(function () {
    Route::get('/warga/create', [WargaController::class, 'create'])->name('warga.create');
    Route::post('/warga', [WargaController::class, 'store'])->name('warga.store');
    Route::get('/warga/{id}/edit', [WargaController::class, 'edit'])->name('warga.edit');
    Route::put('/warga/{id}', [WargaController::class, 'update'])->name('warga.update');
    Route::delete('/warga/{id}', [WargaController::class, 'destroy'])->name('warga.destroy');
});

// ================== AUTH ==================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================== ULASAN ==================

// index → publik
Route::get('/ulasan', [UlasanProdukController::class, 'index'])->name('ulasan.index');

Route::middleware('auth')->group(function () {

    // CRUD ULASAN
    Route::get('/ulasan/create', [UlasanProdukController::class, 'create'])->name('ulasan.create');
    Route::post('/ulasan', [UlasanProdukController::class, 'store'])->name('ulasan.store');
    Route::get('/ulasan/{id}/edit', [UlasanProdukController::class, 'edit'])->name('ulasan.edit');
    Route::put('/ulasan/{id}', [UlasanProdukController::class, 'update'])->name('ulasan.update');
    Route::delete('/ulasan/{id}', [UlasanProdukController::class, 'destroy'])->name('ulasan.destroy');

    // DELETE FOTO SATUAN
    Route::delete('/ulasan/media/{id}', [UlasanProdukController::class, 'destroyMedia'])
        ->name('ulasan.media.destroy');

    // 🔥 ROUTE BARU: UPLOAD FOTO TAMBAHAN
    Route::post('/ulasan/{id}/upload-foto', [UlasanProdukController::class, 'uploadFoto'])
        ->name('ulasan.uploadFoto');
});
