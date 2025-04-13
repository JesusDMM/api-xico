<?php

use App\Http\Controllers\AuthController;
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
