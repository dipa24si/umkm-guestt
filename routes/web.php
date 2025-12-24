<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UlasanProdukController;
use App\Http\Controllers\WargaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('pages.user.login');
})->name('login');

Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/');
    }

    return back()->with('error', 'Email atau password salah.');
})->name('login.process');

Route::get('/register', function () {
    return view('pages.user.register');
})->name('register');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

/*
|--------------------------------------------------------------------------
| PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::resource('warga', WargaController::class);

Route::get('/ulasan', [UlasanProdukController::class, 'index'])
    ->name('ulasan.index');

Route::get('/produk/{id}', [DashboardController::class, 'detailProduk'])
    ->name('produk.detail');

/*
|--------------------------------------------------------------------------
| WARGA (ROLE = warga)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:warga'])->group(function () {

    Route::get('/ulasan/create', [UlasanProdukController::class, 'create'])
        ->name('ulasan.create');

    Route::post('/ulasan', [UlasanProdukController::class, 'store'])
        ->name('ulasan.store');

    Route::get('/ulasan/{id}/edit', [UlasanProdukController::class, 'edit'])
        ->name('ulasan.edit');

    Route::put('/ulasan/{id}', [UlasanProdukController::class, 'update'])
        ->name('ulasan.update');

    Route::delete('/ulasan/{id}', [UlasanProdukController::class, 'destroy'])
        ->name('ulasan.destroy');
});

/*
|--------------------------------------------------------------------------
| UMKM (ROLE = umkm)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:umkm'])->group(function () {

    Route::get('/produk/create', [DashboardController::class, 'createProduk'])
        ->name('produk.create');

    Route::post('/produk', [DashboardController::class, 'storeProduk'])
        ->name('produk.store');

    Route::get('/produk/{id}/edit', [DashboardController::class, 'editProduk'])
        ->name('produk.edit');

    Route::put('/produk/{id}', [DashboardController::class, 'updateProduk'])
        ->name('produk.update');

    Route::delete('/produk/{id}', [DashboardController::class, 'deleteProduk'])
        ->name('produk.destroy');
});
