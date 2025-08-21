<?php

use App\Http\Controllers\api\v1\OrigenVuelosController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){

    Route::prefix('/origenVuelo')->group(function(){

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function(){

            //Consultar todos los viajes/destinos de ida
            Route::get('/', [OrigenVuelosController::class, 'obtenerOrigenes']);

            //Elimina un viaje de ida
            Route::delete('/{id}', [OrigenVuelosController::class, 'eliminarOrigen']);

            //--------------------------------------CONSULTAS--------------------------------------

            //Consulta un viaje de ida por su id
            Route::get('/id/{id}', [OrigenVuelosController::class, 'vueloId']);

            //Consulta un viaje de ida por su fecha de ida
            Route::get('/ida/{salida}', [OrigenVuelosController::class, 'vueloSalida']);
            
            //Consulta un viaje de vuelta por su fecha de vuelta
            Route::get('/vuelta/{llegada}', [OrigenVuelosController::class, 'vueloLlegada']);

        });

        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function(){

            //Crea un origen de vuelo
            Route::post('/', [OrigenVuelosController::class, 'crearOrigen']);

            //Editas un vuelo de ida
            Route::put('/{id}', [OrigenVuelosController::class, 'editarOrigen']);

        });

    });

});

?>