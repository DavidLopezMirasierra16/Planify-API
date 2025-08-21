<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    /**
     * Nos registra en la BD
     */
    public function RegistroAPI(Request $datos_crear)
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
     * Funcion que nos devuelve un token que se usará 
     * para algunas funciones de la API
     */
    public function login(Request $request)
    {
        //Validamos los campos que esperamos recibir
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'mensaje' => 'Faltan campos por rellenar o los campos no son válidos',
                'errores' => $e->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['mensaje' => 'Las credenciales proporcionadas son incorrectas'], 401);
        }
        // Generamos un token de acceso para el usuario
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'mensaje' => 'Inicio de sesión exitoso'], 200);
    }

    /**
     * Funcion que nos devuelve todos los datos de un usuario
     */
    public function user(Request $request)
    {
        return $request->user();
    }

    /**
     * Función que nos ayuda a cambiar nuestra contraseña en caso de olvido
     */
    public function recuperarContraseña(Request $request, $email)
    {
        try {
            $request->validate([
                'password' => 'required|string|min:6',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'mensaje' => 'Faltan campos por rellenar o los campos no son válidos',
                'errores' => $e->errors()
            ], 422);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $data = [
                'message' => 'No se encontró el correo: ' . $email,
                'status' => '404'
            ];

            return response()->json($data, 404);
        } else {
            $user->password = Hash::make($request->password);
            $user->save();

            $data = [
                'message' => 'Contraseña actualizada correctamente: ' . $request->password,
                'status' => '200'
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion de cerrar sesion
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada'], 200);
    }
}
