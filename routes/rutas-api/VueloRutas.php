<?php

use App\Http\Controllers\Api\v1\VuelosController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/vuelos')->group(function () {

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {

            //Consulta todos los vuelo
            Route::get('/', [VuelosController::class, 'obtenerVuelos']);

            //Elimina un vuelo
            Route::delete('/{id}', [VuelosController::class, 'eliminarVuelo']);

            //--------------------------------------CONSULTAS--------------------------------------

            //Consulta por el id del vuelo
            Route::get('/{id}', [VuelosController::class, 'vueloId']);

            //Consulta los vuelos por el origen
            Route::get('/origen/{origen}', [VuelosController::class, 'vueloOrigen']);

            //Consulta los vuelos por el destino
            Route::get('/destino/{destino}', [VuelosController::class, 'vueloDestino']);

            //Consulta los vuelos por el precio
            Route::get('/precio/{precio}', [VuelosController::class, 'vueloPrecio']);
        });

        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function () {

            //Crea un vuelo
            Route::post('/', [VuelosController::class, 'crearVuelo']);

            //Edita un vuelo
            Route::put('/{id}', [VuelosController::class, 'editarVuelo']);

        });
    });
});
