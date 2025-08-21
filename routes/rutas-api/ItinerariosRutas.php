<?php

use App\Http\Controllers\Api\v1\ItinerariosController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/itinerarios')->group(function () {

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {

            //Consultar todos los itinerarios
            Route::get('/', [ItinerariosController::class, 'obtenerItinerarios']);

            //--------------------------------------CONSULTAS--------------------------------------

            //Consulta por el id
            Route::get('/id/{id}', [ItinerariosController::class, 'itinerarioId']);

            //Consulta por el id del viaje
            Route::get('/viaje/{id}', [ItinerariosController::class, 'itinerarioViaje']);

            //Consulta por nombre
            Route::get('/nombre/{nombre}', [ItinerariosController::class, 'itinerarioNombre']);

            //Consulta por descripcion
            Route::get('/descripcion/{descripcion}', [ItinerariosController::class, 'itinerarioDescripcion']);

            //Consulta por fecha
            Route::get('/fecha/{fecha}', [ItinerariosController::class, 'itinerarioFecha']);

            //Consulta por ubicacion
            Route::get('/ubicacion/{ubicacion}', [ItinerariosController::class, 'itinerarioUbicacion']);
        });

        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function () {

            //Crear un itinerario
            Route::post('/', [ItinerariosController::class, 'crearItinerario']);

            //Actualizar un itinerario mediante su id
            Route::put('/{id}', [ItinerariosController::class, 'editarItinerario']);

            //Eliminar un itinerario
            Route::delete('/{id}', [ItinerariosController::class, 'eliminarItinerario']);
        });
    });
});
