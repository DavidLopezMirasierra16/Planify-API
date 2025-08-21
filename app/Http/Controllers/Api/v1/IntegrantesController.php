<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Integrante;
use App\Models\User;
use App\Models\Viaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IntegrantesController extends Controller
{
    /**
     * Funcion que nos devuelve todos los integrantes almacenados
     */
    public function obtenerIntegrantes()
    {

        $integrantes = Integrante::with("viaje", "gastos", "tareas")->paginate(10);

        if ($integrantes->isEmpty()) {
            $data = [
                'message' => 'No hay integrantes guardados',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'integrantes' => $integrantes,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos crea un integrante
     */
    public function crearIntegrante(Request $datos_crear)
    {

        $validator = Validator::make($datos_crear->all(), [
            'viaje_fk' => 'required|numeric',
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'edad' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        } else {
            $id_viaje = $datos_crear->viaje_fk;
            $viaje = Viaje::find($id_viaje);

            if (!$viaje) {
                $data = [
                    'message' => 'No se encontro el viaje con el id ' . $id_viaje,
                    'status' => 404
                ];

                return response()->json($data, 404);
            } else {
                $num_integrantes_viaje = $viaje->numero_integrantes; //Cuantos integrantes hay en el campo numero_integrantes de viajes

                $viajes_personas = $viaje->integrantes->count(); //Cuantos integrantes tienen el id del viaje en integrantes

                if ($num_integrantes_viaje == $viajes_personas) {
                    $data = [
                        'message' => 'No se pueden agregar más integrantes al viaje ' . $id_viaje . ' ,cupo completo (' . $viajes_personas . ' integrantes)',
                        'status' => 422
                    ];

                    return response()->json($data, 422);
                } elseif ($num_integrantes_viaje > $viajes_personas) {
                    $new_integrante = Integrante::create([
                        'viaje_fk' => $datos_crear->viaje_fk,
                        'nombre' => $datos_crear->nombre,
                        'apellidos' => $datos_crear->apellidos,
                        'edad' => $datos_crear->edad
                    ]);

                    $data = [
                        'message' => 'Integrante creado con éxito',
                        'integrante' => $new_integrante,
                        'status' => 201
                    ];

                    return response()->json($data, 201);
                }
            }
        }
    }

    /**
     * Funcion que nos edita un integrante en funcion de su id
     */
    public function editarIntegrante($id, Request $datos_editar)
    {

        $integrante_editar = Integrante::find($id);

        if (!$integrante_editar) {
            $data = [
                'message' => 'No se encontro el integrante con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $validator = Validator::make($datos_editar->all(), [
                'nombre' => 'required|string',
                'apellidos' => 'required|string',
                'edad' => 'nullable|numeric'
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validacion',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {
                $viaje = Viaje::find($integrante_editar->viaje_fk);
                $creador_viaje = User::where('id', $viaje->id_creador_viaje)->first();

                if ($creador_viaje->name == $integrante_editar->nombre && $creador_viaje->surnames == $integrante_editar->apellidos) {
                    $data = [
                        'message' => 'No se puede editar los datos del creador del viaje',
                        'status' => 400
                    ];

                    return response()->json($data, 400);
                } else {
                    // $integrante_editar->viaje_fk = $datos_editar->viaje_fk;
                    $integrante_editar->nombre = $datos_editar->nombre;
                    $integrante_editar->apellidos = $datos_editar->apellidos;
                    $integrante_editar->edad = $datos_editar->edad;
                    $integrante_editar->save();

                    $data = [
                        'message' => 'Integrante con el id ' . $id . ' actualizado con éxito',
                        'status' => 200
                    ];

                    return response()->json($data, 200);
                }
            }
        }
    }

    /**
     * Funcion que nos elimina un integrante según su id
     */
    public function eliminarIntegrante($id)
    {

        $integrante_eliminar = Integrante::find($id);

        if (!$integrante_eliminar) {
            $data = [
                'message' => 'No se pudo eliminar el integrante ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $viaje = Viaje::find($integrante_eliminar->viaje_fk);
            $creador_viaje = User::where('id', $viaje->id_creador_viaje)->first();

            if ($creador_viaje->name == $integrante_eliminar->nombre && $creador_viaje->surnames == $integrante_eliminar->apellidos) {
                $data = [
                    'message' => 'No se puede eliminar al creador del viaje',
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {
                $eliminar = $integrante_eliminar->delete();

                if ($eliminar) {
                    $data = [
                        'message' => 'Integrante con el id ' . $id . ' eliminado correctamente',
                        'status' => 200
                    ];
                }

                return response()->json($data, 200);
            }
        }
    }

    //--------------------------------------CONSULTAS--------------------------------------

    /**
     * Funcion que nos consulta un integrante por su id
     */
    public function integranteId($id)
    {

        $integrante_id = Integrante::with("viaje", "gastos", "tareas")->find($id);

        if (!$integrante_id) {
            $data = [
                'message' => 'No hay ningun integrante con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'integrante' => $integrante_id,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un integrante por su nombre
     */
    public function integranteNombre($nombre)
    {

        $integrante_nombre = Integrante::where('nombre', 'like', '%' . $nombre . '%')->with("viaje", "gastos", "tareas")->paginate(10);

        if ($integrante_nombre->isEmpty()) {
            $data = [
                'message' => 'No hay ningun integrante que contenga ' . $nombre . ' en el nombre',
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'integrante' => $integrante_nombre,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un integrante por su apellido
     */
    public function integranteApellidos($apellidos)
    {

        $integrante_apellidos = Integrante::where('apellidos', 'like', '%' . $apellidos . '%')->with("viaje", "gastos", "tareas")->paginate(10);

        if ($integrante_apellidos->isEmpty()) {
            $data = [
                'message' => 'No hay ningun integrante que contenga ' . $apellidos . ' en los apellidos',
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'integrante' => $integrante_apellidos,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un integrante por su edad
     */
    public function integranteEdad($edad)
    {

        $integrante_edad = Integrante::where('edad', $edad)->with("viaje", "gastos", "tareas")->paginate(10);

        if ($integrante_edad->isEmpty()) {
            $data = [
                'message' => 'No hay ningun integrante que tenga ' . $edad . ' año/s',
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'integrante' => $integrante_edad,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que obtiene todos los integrantes de un viaje
     */
    public function integrantesViaje($viaje)
    {

        $integrantes_viaje = Integrante::where('viaje_fk', $viaje)->with("viaje", "gastos", "tareas")->paginate(10);

        if ($integrantes_viaje->isEmpty()) {
            $data = [
                'message' => 'No hay integrantes en el viaje ' . $viaje,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'integrantes' => $integrantes_viaje,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

}
