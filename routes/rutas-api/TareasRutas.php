<?php

use App\Http\Controllers\Api\v1\TareasController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/tareas')->group(function () {

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {

            //Consultar todas las tareas
            Route::get('/', [TareasController::class, 'obtenerTareas']);

            //Elimina una tarea
            Route::delete('/{id}', [TareasController::class, 'eliminarTarea']);

            //--------------------------------------CONSULTAS--------------------------------------

            //Consulta por id
            Route::get('/id/{id}', [TareasController::class, 'tareaId']);

            //Consulta por nombre de la tarea
            Route::get('/nombre/{nombre}', [TareasController::class, 'tareaNombre']);

        });

        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function () {

            //Crear una tarea
            Route::post('/', [TareasController::class, 'crearTarea']);

            //Actualizar una tarea
            Route::put('/{id}', [TareasController::class, 'editarTarea']);

            //Consulta por el integrante asignado
            Route::get('/integrante/{integrante}', [TareasController::class, 'tareaIntegrante']);

            //Consulta por el viaje
            Route::get('/viaje/{viaje}', [TareasController::class, 'tareaViaje']);
        });
    });
});
