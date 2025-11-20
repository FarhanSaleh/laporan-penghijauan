<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return redirect("dashboard");
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes (Memerlukan autentikasi)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Contoh route khusus admin
    // Route::middleware('role:admin')->group(function () {
    //     Route::get('/admin', function () {
    //         return 'Halaman Admin - Hanya untuk Admin';
    //     })->name('admin.index');
    // });

    // // Contoh route untuk admin dan petugas
    // Route::middleware('role:admin,petugas')->group(function () {
    //     Route::get('/laporan', function () {
    //         return 'Halaman Laporan - Untuk Admin dan Petugas';
    //     })->name('laporan.index');
    // });
});
