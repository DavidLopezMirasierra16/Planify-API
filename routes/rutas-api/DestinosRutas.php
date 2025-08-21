<?php

use App\Http\Controllers\Api\v1\DestinosController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/destinos')->group(function () {

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {

            
        });
        
        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function () {
            
            //Consultar todos los destinos
            Route::get('/', [DestinosController::class, 'obtenerDestinos']);
            
            //Consulta por ID
            Route::get('/id/{id}', [DestinosController::class, 'destinoId']);

            //Consulta por nombre
            Route::get('/nombre/{nombre}', [DestinosController::class, 'destinoNombre']);
        });
    });
});
