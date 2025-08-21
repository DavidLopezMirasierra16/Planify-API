<?php

use App\Http\Controllers\Api\v1\HotelesController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(function(){

    Route::prefix('/hoteles')->group(function(){

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function(){

            //Consultar todos los hoteles 
            Route::get('/', [HotelesController::class, 'obtenerHoteles']);

            //Edita un hotel
            Route::put('/{id}', [HotelesController::class, 'editarHotel']);

            //Elimina un hotel
            Route::delete('/{id}', [HotelesController::class, 'eliminarHotel']);

            //--------------------------------------CONSULTAS--------------------------------------

            //Consultar por su id
            Route::get('/{id}', [HotelesController::class, 'hotelId']);

            //Consultar por su nombre
            Route::get('/nombre/{nombre}', [HotelesController::class, 'hotelNombre']);

            //Consultar por su informacion secundaria
            Route::get('/info/{info}', [HotelesController::class, 'hotelInfo']);

            //Consultar por su rating
            Route::get('/rating/{rating}', [HotelesController::class, 'hotelRating']);

            //Consultar por su proovedor
            Route::get('/proveedor/{proveedor}', [HotelesController::class, 'hotelProveedor']);

            //Consultar por su precio
            Route::get('/precio/{precio}', [HotelesController::class, 'hotelPrecio']);

        });

        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function(){

            //Crea un hotel
            Route::post('/', [HotelesController::class, 'crearHotel']);

        });

    });

});

?>