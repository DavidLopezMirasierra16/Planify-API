<?php

use App\Http\Controllers\Api\v1\ActividadesController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/actividades')->group(function () {

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {

            //Consultar todas las actividades
            Route::get('/', [ActividadesController::class, 'obtenerActividades']);

            //--------------------------------------CONSULTAS--------------------------------------

            //Consulta por id
            Route::get('/id/{id}', [ActividadesController::class, 'actividadId']);

            //Consulta por nombre
            Route::get('/nombre/{nombre}', [ActividadesController::class, 'actividadNombre']);

            //Consulta por descripcion
            Route::get('/descripcion/{descripcion}', [ActividadesController::class, 'actividadDescripcion']);

            //Consulta por direccion
            Route::get('/direccion/{direccion}', [ActividadesController::class, 'actividadDireccion']);

            //Consulta por precio
            Route::get('/precio/{precio}', [ActividadesController::class, 'actividadPrecio']);
        });

        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function () {

            //Crea una actividad
            Route::post('/', [ActividadesController::class, 'crearActividad']);

            //Actualizar una actividad
            Route::put('/{id}', [ActividadesController::class, 'editarActividad']);

            //Eliminar una actividad
            Route::delete('/{id}', [ActividadesController::class, 'eliminarActividad']);
        });
    });
});
