<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\IndicatorParameterController;

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
    
    // Halaman statis
    Route::get('/simple_page', function () {
        return view('home.simple_page');
    })->name('simple_page');
    
    Route::get('/shortcodes', function () {
        return view('home.shortcodes');
    })->name('shortcodes');
    
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
});