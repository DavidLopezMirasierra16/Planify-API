<?php

use App\Http\Controllers\Api\v1\DestinoVuelosController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){

    Route::prefix('/destinoVuelo')->group(function(){

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function(){

            //Consultar todos los viajes/destinos de vuelta
            Route::get('/', [DestinoVuelosController::class, 'obtenerDestinos']);

            //Elimina un viaje de vuelta
            Route::delete('/{id}', [DestinoVuelosController::class, 'eliminarDestino']);

            //--------------------------------------CONSULTAS--------------------------------------

            //Consulta un viaje de vuelta por su ID
            Route::get('/id/{id}', [DestinoVuelosController::class, 'vueloId']);

            //Consulta un viaje de ida por su fecha de ida
            Route::get('/ida/{salida}', [DestinoVuelosController::class, 'vueloSalida']);
            
            //Consulta un viaje de vuelta por su fecha de vuelta
            Route::get('/vuelta/{llegada}', [DestinoVuelosController::class, 'vueloLlegada']);
            

        });

        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function(){

            //Crea un destino de vuelo
            Route::post('/', [DestinoVuelosController::class, 'crearDestino']);

            //Edita un destino
            Route::put('/{id}', [DestinoVuelosController::class, 'editarDestino']);

        });

    });

});

?>