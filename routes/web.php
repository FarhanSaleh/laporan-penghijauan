<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\TwoFactorController;

Route::get("/", function () {
    return view('welcome');
});

Route::get("/login", [LoginController::class, "showLoginForm"])->name("login");
Route::get("/register", [LoginController::class, "showRegisterForm"])->name("register");
Route::post("/login", [LoginController::class, "login"]);
Route::post("/register", [LoginController::class, "register"]);
Route::post("/logout", [LoginController::class, "logout"])->name("logout");

Route::middleware("auth")->group(function () {
    // --- Route untuk Setup (Di menu User Profile) ---
    Route::get('/2fa/setup', [TwoFactorController::class, 'showSetupForm'])->name('2fa.setup');
    Route::post('/2fa/enable', [TwoFactorController::class, 'enable'])->name('2fa.enable');
    Route::post('2fa/disable', [TwoFactorController::class, 'disable'])->name('2fa.disable');

    // --- Route untuk Verifikasi Login (JANGAN kena middleware 2fa) ---
    Route::get('/2fa/verify', [TwoFactorController::class, 'showVerifyForm'])->name('2fa.verify');
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.check');

    // --- Route yang DILINDUNGI (Dashboard, dll) ---
    Route::middleware(['2fa'])->group(function () {
        Route::get("/dashboard", [DashboardController::class, "index"])->name(
            "dashboard",
        );

        Route::middleware("role:admin")->group(function () {
            Route::get("/user", [UserController::class, "index"])->name(
                "dashboard.user.index",
            );
            Route::post("/user", [UserController::class, "store"])->name(
                "dashboard.user.store",
            );
            Route::put("/user/{id}", [UserController::class, "update"])->name(
                "dashboard.user.update",
            );
            Route::delete("/user/{id}", [UserController::class, "destroy"])->name(
                "dashboard.user.destroy",
            );

            Route::get("/admin/laporan", [LaporanController::class, "index"])->name(
                "dashboard.laporan.index",
            );
        });

        Route::middleware("role:user")->group(function () {
            Route::get("/laporan", [LaporanController::class, "showByUser"])->name(
                "dashboard.laporan.showByUser",
            );
            Route::post("/laporan", [LaporanController::class, "store"])->name(
                "dashboard.laporan.store",
            );
            Route::put("/laporan/{id}", [LaporanController::class, "update"])->name(
                "dashboard.laporan.update",
            );
            Route::delete("/laporan/{id}", [
                LaporanController::class,
                "destroy",
            ])->name("dashboard.laporan.destroy");
        });

        Route::middleware("role:petugas")->group(function () {
            Route::get("/petugas/laporan", [
                LaporanController::class,
                "index",
            ])->name("dashboard.laporan.petugas");
            Route::post("/laporan/{id}/followup", [
                LaporanController::class,
                "followup",
            ])->name("dashboard.laporan.followup");
        });

        Route::get("/laporan/{id}/followup", [
            LaporanController::class,
            "showFollowup",
        ])->name("dashboard.laporan.showFollowup");

        Route::get("/profile", [UserController::class, "showProfile"])->name("profile.show");
        Route::put("/profile", [UserController::class, "updateProfile"])->name("profile.update");

        Route::middleware("role:admin")->group(function () {
            Route::get("/activity-log", [ActivityLogController::class, "index"])->name("activity-log.index");
        });
    });
});
