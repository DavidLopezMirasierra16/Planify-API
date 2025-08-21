<?php

use App\Http\Controllers\Api\v1\RolesController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(function () {

    Route::prefix('/roles')->group(function () {

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {
            
            //Consulta los roles asignados
            Route::get('/', [RolesController::class, 'obtenerRoles']);

            //Consulta los tipos de roles
            Route::get('/tipos', [RolesController::class, 'tipoRoles']);

            //Cambiar el rol de un usuario
            Route::put('/edit/{id}', [RolesController::class, 'asignarRol']);
        });
    });
});
