<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

//Get any password hashed
Route::get('/hash-password/{password}', [AuthController::class, 'getAnyHashPassword'])->name('auth.getAnyHashPassword');

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

//All calls inside the next group it'll work asking for jwt token
Route::group(['middleware' => [JwtMiddleware::class]], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/refresh-token', [AuthController::class, 'refreshToken'])->name('auth.refreshToken');

    //This is an example you ought to erase it and create your own
    Route::get('/users', [UsersController::class, 'getAllUsers'])->name('getAllUsers');
});

Route::prefix('/lotes')->group(function () {
    Route::get('', [LoteController::class, 'index']);
    Route::post('', [LoteController::class, 'store']);
    Route::get('/{id}', [LoteController::class, 'show']);
    Route::patch('/{id}', [LoteController::class, 'update']);
    Route::delete('/{id}', [LoteController::class, 'destroy']);
});

Route::prefix('/salidas')->group(function () {
    Route::get('', [SalidaController::class, 'index']);
    Route::get('/{id}', [SalidaController::class, 'show']);
    Route::post('', [SalidaController::class, 'store']);
    Route::patch('/{id}', [SalidaController::class, 'update']);
    Route::delete('/{id}', [SalidaController::class, 'destroy']);
});
