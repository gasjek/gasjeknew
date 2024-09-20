<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DriverController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/pengguna', [AuthController::class, 'index'])->name('pengguna.index');
        Route::post('/pengguna_logout', [AuthController::class, 'logout'])->name('pengguna.logout');

        Route::post('/pengguna/update-password', [AuthController::class, 'updatePassword'])->name('pengguna.updatePassword');
        Route::put('/pengguna/update', [AuthController::class, 'updateUser'])->name('pengguna.updateUser');
        Route::put('/pengguna/update-fcm', [AuthController::class, 'updateFCMToken'])->name('pengguna.updateFCMToken');
        Route::put('/pengguna/update-saldo', [AuthController::class, 'updateSaldo'])->name('pengguna.updateSaldo');
        Route::put('/pengguna/check-saldo', [AuthController::class, 'checkSaldo'])->name('pengguna.checkSaldo');
        Route::put('/pengguna/forgot-password', [AuthController::class, 'forgotPassword'])->name('pengguna.forgotPassword');
        Route::put('/pengguna/reset-password', [AuthController::class, 'resetPassword'])->name('pengguna.resetPassword');
        Route::put('/pengguna/operating-hours', [AuthController::class, 'operatingHours'])->name('pengguna.operatingHours');
    });

    Route::controller(DriverController::class)->group(function () {
        Route::get('/driver', 'index')->name('driver.index');
        Route::put('/driver/update-vehicle', 'updateVehicle')->name('driver.updateVehicle');
        Route::patch('/driver/update-fcm', 'updateFCMToken')->name('driver.updateFCMToken');
    });
});

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/pengguna_login', 'login')->name('pengguna.login');
        Route::post('/pengguna_register', 'register')->name('pengguna.register');
        Route::patch('/pengguna/verify', [AuthController::class, 'verify'])->name('pengguna.verify');
        Route::patch('/pengguna/otp-request', [AuthController::class, 'otpRequest'])->name('pengguna.otpRequest');
        Route::put('/pengguna/forgotPassword', [AuthController::class, 'forgotPassword'])->name('pengguna.forgotPassword');
    });

    Route::controller(DriverController::class)->group(function () {
        Route::post('/driver_login', 'login')->name('driver.login');
        Route::post('/driver_register', 'register')->name('driver.register');
    });
});
