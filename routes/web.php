<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\IndicatorParameterController;
use App\Http\Controllers\RKinerjaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root berdasarkan status autentikasi
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Rute untuk autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// Rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('home.dashboard');
    })->name('dashboard');
    
    // Manajemen Pegawai
    Route::prefix('profil-pegawai')->group(function () {
        Route::get('/', [PegawaiController::class, 'index'])->name('profil_pegawai');
        Route::post('/', [PegawaiController::class, 'store'])->name('profil_pegawai.store');
        Route::get('/{id}/edit', [PegawaiController::class, 'edit'])->name('profil_pegawai.edit');
        Route::put('/{id}', [PegawaiController::class, 'update'])->name('profil_pegawai.update');
        Route::delete('/{user}', [PegawaiController::class, 'destroy'])->name('profil_pegawai.destroy');
    });
    
    // Manajemen Parameter Indikator
    Route::prefix('parameter-indikator')->group(function () {
        Route::get('/', [IndicatorParameterController::class, 'index'])->name('parameter-indikator');
        Route::post('/', [IndicatorParameterController::class, 'store'])->name('parameter-indikator.store');
        Route::put('/{id}', [IndicatorParameterController::class, 'update'])->name('parameter-indikator.update');
        Route::delete('/{id}', [IndicatorParameterController::class, 'destroy'])->name('parameter-indikator.destroy');
    });

    // Realisasi Kinerja Routes
    Route::prefix('realisasi-kinerja')->group(function () {
        Route::get('/', [RKinerjaController::class, 'index'])->name('realisasi_kinerja');
        Route::get('/create', [RKinerjaController::class, 'create'])->name('realisasi_kinerja.create');
        Route::post('/', [RKinerjaController::class, 'store'])->name('realisasi_kinerja.store');
        Route::get('/{id}/edit', [RKinerjaController::class, 'edit'])->name('realisasi_kinerja.edit');
        Route::put('/{id}', [RKinerjaController::class, 'update'])->name('realisasi_kinerja.update');
        Route::delete('/{id}', [RKinerjaController::class, 'destroy'])->name('realisasi_kinerja.destroy');
    });
});