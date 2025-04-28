<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\EspecificacionIncidenciaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

//Get any password hashed
Route::get('/hash-password/{password}', [AuthController::class, 'getAnyHashPassword'])->name('auth.getAnyHashPassword');

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');

//All calls inside the next group it'll work asking for jwt token
Route::group(['middleware' => [JwtMiddleware::class]], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    //This is an example you ought to erase it and create your own
    Route::get('/users', [UsersController::class, 'getAllUsers'])->name('getAllUsers');
    Route::get('/users/{id}', [UsersController::class, 'getUserById'])->name('getUserById');
});

Route::prefix('/lotes')->group(function () {
    Route::get('/info', [LoteController::class, 'getLotesConSalidasYIncidencias']);
    Route::get('/info/{loteId}', [LoteController::class, 'getLoteConSalidasYIncidencias']);
    Route::get('', [LoteController::class, 'index']);
    Route::post('', [LoteController::class, 'store']);
    Route::get('/{id}', [LoteController::class, 'show']);
    Route::patch('/{id}', [LoteController::class, 'update']);
    Route::delete('/{id}', [LoteController::class, 'destroy']);
});

Route::prefix('/salidas')->group(function () {
    Route::get('', [SalidaController::class, 'index']);
    Route::get('/{id}', [SalidaController::class, 'show']);
    Route::get('/lote/{lote_id}', [SalidaController::class, 'getByLoteId']);
    Route::post('', [SalidaController::class, 'store']);
    Route::patch('/{id}', [SalidaController::class, 'update']);
    Route::delete('/{id}', [SalidaController::class, 'destroy']);
});

Route::prefix('/incidencias')->group(function () {
    Route::get('', [EspecificacionIncidenciaController::class, 'index']);
    Route::get('/{id}', [EspecificacionIncidenciaController::class, 'show']);
    Route::get('/lote/{lote_id}', [EspecificacionIncidenciaController::class, 'getByLoteId']);
    Route::get('/salida/{salida_id}', [EspecificacionIncidenciaController::class, 'getBySalidaId']);
    Route::post('', [EspecificacionIncidenciaController::class, 'store']);
    Route::patch('/{id}', [EspecificacionIncidenciaController::class, 'update']);
    Route::delete('/{id}', [EspecificacionIncidenciaController::class, 'destroy']);
});

Route::prefix('/productos')->group(function () {
    Route::get('', [ProductoController::class, 'getIdAndNombre']);
    Route::get('/detalles', [ProductoController::class, 'getIdNombrePresentacionCategoria']);
    Route::get('/categorias', [ProductoController::class, 'getCategoriasUnicas']);
    Route::get('/{categoria}', [ProductoController::class, 'getByCategoria']);
});
