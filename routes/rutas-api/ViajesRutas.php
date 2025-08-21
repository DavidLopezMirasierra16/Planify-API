<?php

use App\Http\Controllers\Api\v1\ViajesController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/viajes')->group(function () {

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {

            //Consultar todos los viajes
            Route::get('/', [ViajesController::class, 'obtenerViajes']);

            //Crear un viaje por el nombre del destino y origen 
            Route::post('/nombre', [ViajesController::class, 'crearViajeNombre']);

            //Actualizar un viaje mediante su id agregando el nombre del origen y destino en el JSON
            Route::put('/nombre/{id}', [ViajesController::class, 'editarViajeNombre']);

            //Elimina un viaje
            Route::delete('/{id}', [ViajesController::class, 'eliminarViaje']);

            //--------------------------------------CONSULTAS--------------------------------------

            //Consulta por el id del origen
            Route::get('/origen/id/{id}', [ViajesController::class, 'viajeOrigenId']);

            //Consulta por el nombre del origen
            Route::get('/origen/nombre/{nombre}', [ViajesController::class, 'viajeOrigenNombre']);

            //Consulta por fecha de llegada
            Route::get('/llegada/{fecha}', [ViajesController::class, 'viajeLlegada']);

            //Consulta por fecha de salida
            Route::get('/salida/{fecha}', [ViajesController::class, 'viajeSalida']);

            //Consulta por número de integrantes
            Route::get('/integrantes/{integrantes}', [ViajesController::class, 'viajeIntegrantes']);
        });

        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function () {

            //Crear un viaje por el id de destino y origen
            Route::post('/', [ViajesController::class, 'crearViajeId']);

            //Actualizar un viaje mediante su id agregando el id del origen y destino en el JSON
            Route::put('/{id}', [ViajesController::class, 'editarViajeId']);

            //Consultar sus viajes
            Route::get('/usuario/{id}', [ViajesController::class, 'viajeUser']);

            //Consulta por id
            Route::get('/id/{id}', [ViajesController::class, 'viajeId']);

            //Consulta por el id del destino
            Route::get('/destino/id/{id}', [ViajesController::class, 'viajeDestinoId']);

            //Consulta por el nombre del destino
            Route::get('/destino/nombre/{nombre}', [ViajesController::class, 'viajeDestinoNombre']);

        });
    });
});
