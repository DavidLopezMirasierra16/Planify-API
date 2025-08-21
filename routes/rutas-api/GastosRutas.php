<?php

use App\Http\Controllers\Api\v1\GastosController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/gastos')->group(function () {

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {

            //Consultar todos los gastos
            Route::get('/', [GastosController::class, 'obtenerGastos']);

            //Elimina una gasto
            Route::delete('/{id}', [GastosController::class, 'eliminarGasto']);

            //--------------------------------------CONSULTAS--------------------------------------

            //Consulta por id
            Route::get('/id/{id}', [GastosController::class, 'gastoId']);

            //Consulta por valor
            Route::get('/valor/{valor}', [GastosController::class, 'gastoValor']);

            //Consulta por integrante
            Route::get('/integrante/{integrante}', [GastosController::class, 'gastoIntegrante']);

            //Consulta por pagado
            Route::get('/pagado/{numero}', [GastosController::class, 'gastoPagado']);

            //Consulta por descripcion
            Route::get('/descripcion/{descripcion}', [GastosController::class, 'gastoDescripcion']);
        });

        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function () {

            //Crear un gasto
            Route::post('/', [GastosController::class, 'crearGasto']);

            //Actualizar un gasto
            Route::put('/{id}', [GastosController::class, 'editarGasto']);

            //Gastos del usuario
            Route::get('/usuario/{id}', [GastosController::class, 'gastoUser']);

            //Gastos de un viaje
            Route::get('/viaje/{viaje}', [GastosController::class, 'gastoViaje']);

        });
    });
});
