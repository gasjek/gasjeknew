<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pengguna', [AuthController::class, 'index'])->name('pengguna.index');
    Route::post('/pengguna_logout', [AuthController::class, 'logout'])->name('pengguna.logout');

    // update password dan edit user
    Route::post('/pengguna/update-password', [AuthController::class, 'updatePassword'])->name('pengguna.updatePassword');
    Route::put('/pengguna/update-user', [AuthController::class, 'updateUser'])->name('pengguna.updateUser');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/pengguna_login', 'login')->name('pengguna.login');
    Route::post('/pengguna_register', 'register')->name('pengguna.register');
});
