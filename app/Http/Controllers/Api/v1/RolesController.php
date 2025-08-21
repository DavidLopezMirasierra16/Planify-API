<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{

    /**
     * Funcion que nos devuelve todos los roles
     */
    public function tipoRoles()
    {

        $roles = Role::all();

        if (!$roles) {
            $data = [
                'message' => 'No hay roles almacenados',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'roles' => $roles,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos devuelve todos los roles asignados
     */
    public function obtenerRoles()
    {
        $roles_asignados = RoleUser::with('user')->get();

        if ($roles_asignados->isEmpty()) {
            $data = [
                'message' => 'No hay roles asignados',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'roles' => $roles_asignados,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que te permitirá cambiar el rol al usuario
     */
    public function asignarRol(Request $datos_editar, $id)
    {
        $usuario = RoleUser::where('user_id', $id)->get();

        if (!$usuario) {
            $data = [
                'message' => 'No se encuentra al usuario con ID ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $validator = Validator::make($datos_editar->all(), [
                'role_id' => 'required|numeric|min:0|max:1'
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validacion',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {
                $usuario->role_id = $datos_editar->role_id;
                $usuario->save();

                $data = [
                    'message' => 'Rol del usuario ' . $usuario->user()->name . ' con ID ' . $id . ' actualizado con éxito',
                    'status' => 200
                ];

                return response()->json($data, 200);
            }
        }
    }
}
