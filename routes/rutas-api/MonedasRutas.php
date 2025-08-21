<?php

use App\Http\Controllers\Api\v1\MonedasController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/monedas')->group(function () {

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {

            //Consulta por id
            Route::get('/id/{id}', [MonedasController::class, 'monedasId']);

            //Consulta por su id
            Route::get('/nombre/{nombre}', [MonedasController::class, 'monedasNombre']);
        });

        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function () {

            //Consultar todas las monedas
            Route::get('/', [MonedasController::class, 'obtenerMonedas']);
        });
    });
});
