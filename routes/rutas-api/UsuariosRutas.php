<?php

use App\Http\Controllers\Api\v1\UsuariosController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/usuarios')->group(function () {

        Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {

            //Consultar todos los usuarios
            Route::get('/', [UsuariosController::class, 'obtenerUsuarios']);

            //--------------------------------------CONSULTAS--------------------------------------

            //Consulta por ID
            Route::get('/id/{id}', [UsuariosController::class, 'usuarioId']);

            //Consulta por nombre
            Route::get('/nombre/{nombre}', [UsuariosController::class, 'usuarioNombre']);

            //Consulta por apellidos
            Route::get('/apellidos/{apellidos}', [UsuariosController::class, 'usuarioApellidos']);

            //Consulta por telefono
            Route::get('/telefono/{telefono}', [UsuariosController::class, 'usuarioTelefono']);
        });

        Route::middleware(['auth:sanctum', 'role:Administrador,Cliente'])->group(function () {

            //Crear un usuario
            Route::post('/', [UsuariosController::class, 'crearUsuario']);

            //Actualizar por correo
            Route::put('/correo/{correo}', [UsuariosController::class, 'editarCorreo']);

            //Consulta por correo
            Route::get('/correo/{correo}', [UsuariosController::class, 'usuarioCorreo']);
            
            //Actualizar un usuario
            Route::put('/{id}', [UsuariosController::class, 'editarUsuario']);

            //Eliminar por correo
            Route::delete('/correo/{correo}', [UsuariosController::class, 'eliminarCorreo']);

            //Eliminar un usuario
            Route::delete('/{id}', [UsuariosController::class, 'eliminarUsuario']);
        });
    });
});
