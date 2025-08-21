<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{

    /**
     * Funcion que nos devuelve todos los usuarios almacenados
     */
    public function obtenerUsuarios()
    {

        $usuarios = User::with('viajes', 'roles')->paginate(10);

        if ($usuarios->isEmpty()) {
            $data = [
                'message' => 'No hay usuarios guardados',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'usuarios' => $usuarios,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos crea un usuario
     */
    public function crearUsuario(Request $datos_crear)
    {

        $validator = Validator::make($datos_crear->all(), [
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:15|unique:users,phone_number',
            'correo' => 'required|email|unique:users,email',
            'contrasenia' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        } else {
            $usuario = User::create([
                'name' => $datos_crear->nombre,
                'surnames' => $datos_crear->apellidos,
                'phone_number' => $datos_crear->telefono,
                'email' => $datos_crear->correo,
                'password' => Hash::make($datos_crear->contrasenia)
            ]);

            if (!$usuario) {
                $data = [
                    'message' => 'Error en la creacion del usuario',
                    'status' => 500
                ];

                return response()->json($data, 500);
            } else {
                $rol = strpos($usuario->email, '@planify.es');

                $new_rol_user = RoleUser::create([
                    "role_id" => $rol == true ? 1 : 2,
                    "user_id" => $usuario->id
                ]);

                $data = [
                    'message' => 'Usuario creado con éxito',
                    'usuario' => $usuario,
                    'status' => 201
                ];

                return response()->json($data, 201);
            }
        }
    }

    /**
     * Funcion que nos actualiza un usuario según su id
     */
    public function editarUsuario($id, Request $datos_editar)
    {

        $usuario_editar = User::find($id);

        if (!$usuario_editar) {
            $data = [
                'message' => 'No se encontro el usuario con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {

            $validator = Validator::make($datos_editar->all(), [
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'telefono' => 'required|string|max:15',
                'correo' => 'required|email',
                'contrasenia' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validacion',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {
                $correo_duplicado = User::where('email', $datos_editar->correo) //Buscamos el email en la bd
                    ->where('id', '!=', $usuario_editar->id) //Comprobamos que está registrado en otro ID que no sea el del usuario
                    ->exists();

                if (!$correo_duplicado) {
                    $usuario_editar->name = $datos_editar->nombre;
                    $usuario_editar->surnames = $datos_editar->apellidos;
                    $usuario_editar->phone_number = $datos_editar->telefono;
                    $usuario_editar->email = $datos_editar->correo;
                    $usuario_editar->password = Hash::make($datos_editar->contrasenia);
                    $usuario_editar->save();

                    $data = [
                        'message' => 'Usuario con el id ' . $id . ' actualizado con éxito',
                        'status' => 200
                    ];

                    return response()->json($data, 200);
                } else {
                    $data = [
                        'message' => 'Ese no es el correo del usuario (correo registrado por otro usuario)',
                        'status' => 400
                    ];

                    return response()->json($data, 400);
                }
            }
        }
    }

    /**
     * Funcion que nos actualiza por el correo
     */
    public function editarCorreo(Request $datos_correo, $correo)
    {
        $usuario_editar = User::where('email', $correo)->first();

        if (!$usuario_editar) {
            $data = [
                'message' => 'No se encontro el usuario con el correo ' . $correo,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {

            $validator = Validator::make($datos_correo->all(), [
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'telefono' => 'required|string|max:15',
                'correo' => 'required|email',
                'contrasenia' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validacion',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {
                $correo_duplicado = User::where('email', $datos_correo->correo) //Buscamos el email en la bd
                    ->where('id', '!=', $usuario_editar->id) //Comprobamos que está registrado en otro ID que no sea el del usuario
                    ->exists();

                if (!$correo_duplicado) { //Verificamos que el correo que guardamos no este verificado
                    $usuario_editar->name = $datos_correo->nombre;
                    $usuario_editar->surnames = $datos_correo->apellidos;
                    $usuario_editar->phone_number = $datos_correo->telefono;
                    $usuario_editar->email = $datos_correo->correo;
                    $usuario_editar->password = Hash::make($datos_correo->contrasenia);
                    $usuario_editar->save();

                    $data = [
                        'message' => 'Usuario con el correo ' . $correo . ' actualizado con éxito',
                        'status' => 200
                    ];

                    return response()->json($data, 200);
                } else {
                    $data = [
                        'message' => 'Ese no es el correo del usuario (correo registrado por otro usuario)',
                        'status' => 400
                    ];

                    return response()->json($data, 400);
                }
            }
        }
    }

    /**
     * Funcion que nos elimina un usuario según su id
     */
    public function eliminarUsuario($id)
    {

        $usuario_eliminar = User::find($id);

        if (!$usuario_eliminar) {
            $data = [
                'message' => 'No se pudo eliminar el usuario ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $eliminar = $usuario_eliminar->delete();

            if ($eliminar) {
                $data = [
                    'message' => 'Usuario con el id ' . $id . ' eliminado correctamente',
                    'status' => 200
                ];
            }

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos elimina un usuario por su correo
     */
    public function eliminarCorreo($correo)
    {
        $usuario_eliminar = User::where('email', $correo)->first();

        if (!$usuario_eliminar) {
            $data = [
                'message' => 'No se pudo eliminar el usuario con el correo ' . $correo,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $eliminar = $usuario_eliminar->delete();

            if ($eliminar) {
                $data = [
                    'message' => 'Usuario con el correo ' . $correo . ' eliminado correctamente',
                    'status' => 200
                ];
            }

            return response()->json($data, 200);
        }
    }

    //--------------------------------------CONSULTAS--------------------------------------

    /**
     * Funcion que nos consulta un usuario por su id
     */
    public function usuarioId($id)
    {

        $usuario_id = User::with('viajes', 'roles')->find($id);

        if (!$usuario_id) {
            $data = [
                'message' => 'No hay ninguna usuario con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'usuario' => $usuario_id,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un usuario por su nombre
     */
    public function usuarioNombre($nombre)
    {

        $usuario_nombre = User::where('name', 'like', '%' . $nombre . '%')->with('viajes', 'roles')->paginate(10);

        if ($usuario_nombre->isEmpty()) {
            $data = [
                'message' => 'No hay usuarios que incluyan en el nombre ' . $nombre,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'usuario' => $usuario_nombre,
                'status' => 202
            ];

            return response()->json($data, 202);
        }
    }

    /**
     * Funcion que nos consulta un usuario por su apellido
     */
    public function usuarioApellidos($apellidos)
    {

        $usuario_apellidos = User::where('surnames', 'like', '%' . $apellidos . '%')->with('viajes', 'roles')->paginate(10);

        if ($usuario_apellidos->isEmpty()) {
            $data = [
                'message' => 'No hay usuarios que incluyan en el apellido ' . $apellidos,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'usuario' => $usuario_apellidos,
                'status' => 202
            ];

            return response()->json($data, 202);
        }
    }

    /**
     * Funcion que nos consulta un usuario por su correo
     */
    public function usuarioCorreo($correo)
    {

        $usuario_correo = User::where('email', 'like', '%' . $correo . '%')->with('viajes', 'roles')->get();

        if ($usuario_correo->isEmpty()) {
            $data = [
                'message' => 'No hay correos que incluyan ' . $correo,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'usuario' => $usuario_correo,
                'status' => 202
            ];

            return response()->json($data, 202);
        }
    }

    /**
     * Funcion que nos consulta un usuario por su telefono
     */
    public function usuarioTelefono($telefono)
    {

        $usuario_telefono = User::where('phone_number', 'like', '%' . $telefono . '%')->with('viajes', 'roles')->first();

        if (!$usuario_telefono) {
            $data = [
                'message' => 'No hay correos que incluyan ' . $telefono,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'usuario' => $usuario_telefono,
                'status' => 202
            ];

            return response()->json($data, 202);
        }
    }
}
