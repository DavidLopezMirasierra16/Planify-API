<?php

use App\Http\Controllers\Api\v1\OrigenesController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/origenes')->group(function () {

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {

            
        });
        
        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function () {
            
            //Consultar todas las rutas
            Route::get('/', [OrigenesController::class, 'obtenerOrigenes']);
            
            //Consultar por id
            Route::get('/id/{id}', [OrigenesController::class, 'origenesId']);

            //Consultar por ciudad
            Route::get('/nombre/{nombre}', [OrigenesController::class, 'origenesNombre']);
        });
    });
});
