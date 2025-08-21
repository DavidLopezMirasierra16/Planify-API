<?php

use App\Http\Controllers\Api\v1\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('/registro', [AuthController::class, 'registroAPI']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::put('/recuperarContraseña/{email}', [AuthController::class, 'recuperarContraseña']);

    //Rutas protegidas con Sanctum (dentro del grupo de la versión)
    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/perfil', [AuthController::class, 'user']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
