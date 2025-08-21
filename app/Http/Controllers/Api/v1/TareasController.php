<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Integrante;
use App\Models\Tarea;
use App\Models\Viaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TareasController extends Controller
{

    /**
     * Funcion que nos devuelve todas las tareas
     */
    public function obtenerTareas()
    {

        $tareas = Tarea::with("integrante")->get();

        if ($tareas->isEmpty()) {
            $data = [
                'message' => 'No hay tareas guardados',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'tareas' => $tareas,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos crea una tarea
     */
    public function crearTarea(Request $datos_crear)
    {

        $validator = Validator::make($datos_crear->all(), [
            'nombre_tarea' => 'required|string|max:255',
            'asignada_fk' => 'required|numeric',
            'completado' => 'required|numeric|min:0|max:1',
            'viaje_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        } else {
            $viaje = Viaje::find($datos_crear->viaje_id);

            if (!$viaje) {
                $data = [
                    'message' => 'No se encuentra el viaje con el id ' . $datos_crear->viaje_id,
                    'status' => 404
                ];

                return response()->json($data, 404);
            } else {
                $integrante = Integrante::where('id_integrante', $datos_crear->asignada_fk) //Buscamos la integrante por el id de integrante
                    ->where('viaje_fk', $datos_crear->viaje_id) //Comprobamos que esa integrate esté en el viaje
                    ->first();

                if (!$integrante) {
                    $data = [
                        'message' => 'Ese integrante no está asociado a ese viaje',
                        'status' => 400
                    ];

                    return response()->json($data, 400);
                } else {
                    $new_tarea = Tarea::create([
                        "nombre_tarea" => $datos_crear->nombre_tarea,
                        "asignada_fk" => $datos_crear->asignada_fk,
                        "completado" => $datos_crear->completado,
                        "viaje_id" => $datos_crear->viaje_id
                    ]);

                    $data = [
                        'message' => 'Tarea creada con éxito',
                        'tarea' => $new_tarea,
                        'status' => 201
                    ];

                    return response()->json($data, 201);
                }
            }
        }
    }

    /**
     * Funcion que nos edita una tarea en funcion de su id
     */
    public function editarTarea($id, Request $datos_editar)
    {

        $tarea_editar = Tarea::find($id);

        if (!$tarea_editar) {
            $data = [
                'message' => 'No se encontro la tarea con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $validator = Validator::make($datos_editar->all(), [
                'nombre_tarea' => 'required|string|max:255',
                'asignada_fk' => 'required|numeric',
                'completado' => 'required|numeric|min:0|max:1',
                'viaje_id' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validacion',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {
                $viaje = Viaje::find($datos_editar->viaje_id);

                if (!$viaje) {
                    $data = [
                        'message' => 'No se encuentra el viaje con el id ' . $datos_editar->viaje_id,
                        'status' => 404
                    ];

                    return response()->json($data, 404);
                } else {
                    $integrante = Integrante::where('id_integrante', $datos_editar->asignada_fk) //Buscamos la integrante por el id de integrante
                        ->where('viaje_fk', $datos_editar->viaje_id) //Comprobamos que esa integrate esté en el viaje
                        ->first();

                    if (!$integrante) {
                        $data = [
                            'message' => 'Ese integrante no está asociado a ese viaje',
                            'status' => 400
                        ];

                        return response()->json($data, 400);
                    } else {
                        $tarea_editar->nombre_tarea = $datos_editar->nombre_tarea;
                        $tarea_editar->asignada_fk = $datos_editar->asignada_fk;
                        $tarea_editar->completado = $datos_editar->completado;
                        $tarea_editar->viaje_id = $datos_editar->viaje_id;
                        $tarea_editar->save();

                        $data = [
                            'message' => 'Tarea con el id ' . $id . ' actualizada con éxito',
                            'status' => 200
                        ];

                        return response()->json($data, 200);
                    }
                }
            }
        }
    }

    /**
     * Funcion que nos elimina una tarea según su id
     */
    public function eliminarTarea($id)
    {

        $tarea_eliminar = Tarea::find($id);

        if (!$tarea_eliminar) {
            $data = [
                'message' => 'No se pudo eliminar la tarea número ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $eliminar = $tarea_eliminar->delete();

            if ($eliminar) {
                $data = [
                    'message' => 'Tarea número ' . $id . ' eliminada correctamente',
                    'status' => 200
                ];
            }

            return response()->json($data, 200);
        }
    }

    //--------------------------------------CONSULTAS--------------------------------------

    /**
     * Funcion que nos consulta una tarea por su id
     */
    public function tareaId($id)
    {

        $tarea_id = Tarea::with("integrante", "viaje")->find($id);

        if (!$tarea_id) {
            $data = [
                'message' => 'No hay ninguna tarea con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'tarea' => $tarea_id,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta una tarea por su nombre
     */
    public function tareaNombre($nombre)
    {

        $tarea_nombre = Tarea::where('nombre_tarea', 'like', '%' . $nombre . '%')->with("integrante", "viaje")->get();

        if ($tarea_nombre->isEmpty()) {
            $data = [
                'message' => 'No hay ninguna tarea que contenga ' . $nombre . ' en el nombre',
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'tarea' => $tarea_nombre,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta las tareas de un integrante por su id
     */
    public function tareaIntegrante($integrante)
    {

        $integrante_busqueda = Integrante::find($integrante);

        if (!$integrante_busqueda) {
            $data = [
                'message' => 'No hay ningun integrante con el id ' . $integrante,
                'status' => 400
            ];

            return response()->json($data, 400);
        } else {
            $tareas_integrante = $integrante_busqueda->tareas;

            if ($tareas_integrante->isEmpty()) {
                $data = [
                    'message' => 'No se encontraron tareas para el usuario ' . $integrante_busqueda->nombre . ' ' . $integrante_busqueda->apellidos,
                    'status' => 404
                ];

                return response()->json($data, 404);
            } else {
                $data = [
                    'tarea' => $tareas_integrante,
                    'status' => 200
                ];

                return response()->json($data, 200);
            }
        }
    }

    /**
     * Función que nos obtiene las tareas de un viaje
     */
    public function tareaViaje($viaje) 
    {
        $tareas = Tarea::where('viaje_id', $viaje)->with("integrante", "viaje")->paginate(10);

        if ($tareas->isEmpty()) {
            $data = [
                'message' => 'No hay tareas en el viaje ' . $viaje,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'tareas' => $tareas,
                'status' => 200
            ];

            return response()->json($data, 200);
        }

    }
}
