<?php

use App\Http\Controllers\Api\v1\IntegrantesController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/integrantes')->group(function () {

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {

            //Consultar todos los integrantes
            Route::get('/', [IntegrantesController::class, 'obtenerIntegrantes']);

            //--------------------------------------CONSULTAS--------------------------------------

            //Consulta por nombre
            Route::get('/nombre/{nombre}', [IntegrantesController::class, 'integranteNombre']);

            //Consulta por apellidos
            Route::get('/apellidos/{apellidos}', [IntegrantesController::class, 'integranteApellidos']);

            //Consulta por edad
            Route::get('/edad/{edad}', [IntegrantesController::class, 'integranteEdad']);
        });

        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function () {

            //Crear un integrante
            Route::post('/', [IntegrantesController::class, 'crearIntegrante']);

            //Consulta por id
            Route::get('/id/{id}', [IntegrantesController::class, 'integranteId']);

            //Consulta los integrantes de un viaje
            Route::get('/viaje/{id}', [IntegrantesController::class, 'integrantesViaje']);

            //Actualizar un integrante mediante su id
            Route::put('/{id}', [IntegrantesController::class, 'editarIntegrante']);

            //Eliminar un integrante
            Route::delete('/{id}', [IntegrantesController::class, 'eliminarIntegrante']);
        });
    });
});
