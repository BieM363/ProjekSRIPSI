<?php

use Illuminate\Support\Facades\Route;

//import product controller
// use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;

//route resource for products
// Route::resource('/products', ProductController::class);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

// Proses login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Group route yang butuh autentikasi
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/home/dashboard', function () {
        return view('home.dashboard');
    })->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});

// (Optional) Redirect root ke dashboard atau login
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Semua route ini dilindungi middleware auth
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('home.dashboard');
    })->name('dashboard');

    // Simple Page & Shortcodes
    Route::get('/simple_page', function () {
        return view('home.simple_page');
    })->name('simple_page');

    Route::get('/shortcodes', function () {
        return view('home.shortcodes');
    })->name('shortcodes');

    // Profil Pegawai
    Route::get(
        '/profil-pegawai',
        [PegawaiController::class, 'index']
    )->name('profil_pegawai');

    Route::post(
        '/profil-pegawai',
        [PegawaiController::class, 'store']
    )->name('profil_pegawai.store');

    Route::delete('/profil-pegawai/{user}', [PegawaiController::class, 'destroy'])
         ->name('profil_pegawai.destroy');
});
