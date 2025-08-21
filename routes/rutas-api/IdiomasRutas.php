<?php

use App\Http\Controllers\Api\v1\IdiomasController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/idiomas')->group(function () {

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {

            //Consulta por id
            Route::get('/{id}', [IdiomasController::class, 'idiomaId']);
        });

        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function () {

            //Consultar todos los idiomas
            Route::get('/', [IdiomasController::class, 'obtenerIdiomas']);
        });
    });
});
