<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect("dashboard");
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:admin,user')->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('dashboard.user.index');
        Route::post('/user', [UserController::class, 'store'])->name('dashboard.user.store');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('dashboard.user.update');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('dashboard.user.destroy');
    });

    Route::get('/laporan', [LaporanController::class, 'index'])->name('dashboard.laporan.index');
    Route::get('/berita', [BeritaController::class, 'index'])->name('dashboard.berita.index');
});
