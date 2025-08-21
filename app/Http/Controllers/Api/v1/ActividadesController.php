<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Actividade;
use App\Models\Viaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActividadesController extends Controller
{
    /**
     * Funcion que nos devuelve todas las actividades
     */
    public function obtenerActividades()
    {

        $actividades = Actividade::with('viaje')->paginate(10);

        if (!$actividades) {
            $data = [
                'message' => 'No hay actividades guardadas',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'actividades' => $actividades,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos crea una actividad
     */
    public function crearActividad(Request $datos_crear)
    {

        $validator = Validator::make($datos_crear->all(), [
            'nombre_actividad' => 'required|max:45',
            'enlace_actividad' => 'required|max:150|url',
            'descripcion' => 'required|max:45',
            'direccion_actividad' => 'required|max:45',
            'precio' => 'required|numeric',
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
            $comprobar_viaje = Viaje::find($datos_crear->viaje_id);

            if (!$comprobar_viaje) {
                $data = [
                    'message' => 'No hay ningun viaje con el id ' . $datos_crear->viaje_id,
                    'status' => 404
                ];

                return response()->json($data, 404);
            } else {
                $new_actividad = Actividade::create([
                    'nombre_actividad' => $datos_crear->nombre_actividad,
                    'enlace_actividad' => $datos_crear->enlace_actividad,
                    'descripcion' => $datos_crear->descripcion,
                    'direccion_actividad' => $datos_crear->direccion_actividad,
                    'precio' => $datos_crear->precio,
                    'viaje_id' => $datos_crear->viaje_id
                ]);

                if (!$new_actividad) {
                    $data = [
                        'message' => 'Error al crear la actividad',
                        'status' => 500
                    ];

                    return response()->json($data, 500);
                } else {
                    $actividad_creada = Actividade::with('viaje')->find($new_actividad->id_actividad);

                    $data = [
                        'message' => 'Actividad creada con éxito',
                        'actividad' => $actividad_creada,
                        'status' => 201
                    ];

                    return response()->json($data, 201);
                }
            }
        }
    }

    /**
     * Funcion que nos actualiza una actividad según su id
     */
    public function editarActividad($id, Request $datos_editar)
    {

        $actividad_editar = Actividade::find($id);

        if (!$actividad_editar) {
            $data = [
                'message' => 'No se encontro la actividad con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $validator = Validator::make($datos_editar->all(), [
                'nombre_actividad' => 'required|max:45',
                'enlace_actividad' => 'required|max:150|url',
                'descripcion' => 'required|max:45',
                'direccion_actividad' => 'required|max:45',
                'precio' => 'required|numeric',
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
                $comprobar_viaje = Viaje::find($datos_editar->viaje_id);

                if (!$comprobar_viaje) {
                    $data = [
                        'message' => 'No hay ningun viaje con el id ' . $datos_editar->viaje_id,
                        'status' => 404
                    ];

                    return response()->json($data, 404);
                } else {
                    $actividad_editar->nombre_actividad = $datos_editar->nombre_actividad;
                    $actividad_editar->enlace_actividad = $datos_editar->enlace_actividad;
                    $actividad_editar->descripcion = $datos_editar->descripcion;
                    $actividad_editar->direccion_actividad = $datos_editar->direccion_actividad;
                    $actividad_editar->precio = $datos_editar->precio;
                    $actividad_editar->viaje_id = $datos_editar->viaje_id;
                    $actividad_editar->save();

                    $actividad_editada = Actividade::with('viaje')->find($actividad_editar->id_actividad);

                    $data = [
                        'message' => 'Actividad con el id ' . $id . ' actualizada con éxito',
                        'actividad' => $actividad_editada,
                        'status' => 200
                    ];

                    return response()->json($data, 200);
                }
            }
        }
    }

    /**
     * Funcion que nos elimina un actividad según su id
     */
    public function eliminarActividad($id)
    {

        $actividad_eliminar = Actividade::find($id);

        if (!$actividad_eliminar) {
            $data = [
                'message' => 'No se encontró la actividad numero ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $eliminar = $actividad_eliminar->delete();

            if ($eliminar) {
                $data = [
                    'message' => 'Actividad con el id ' . $id . ' eliminada correctamente',
                    'status' => 200
                ];
            }

            return response()->json($data, 200);
        }
    }

    //--------------------------------------CONSULTAS--------------------------------------

    /**
     * Funcion que nos consulta una actividad por su id
     */
    public function actividadId($id)
    {

        $actividad_id = Actividade::with('viaje')->find($id);

        if (!$actividad_id) {
            $data = [
                'message' => 'No hay ninguna actividad con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'actividad' => $actividad_id,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta una actividad por su nombre
     */
    public function actividadNombre($nombre)
    {

        $actividad_nombre = Actividade::where('nombre_actividad', 'like', '%' . $nombre . '%')->with('viaje')->paginate(10);

        if ($actividad_nombre->isEmpty()) {
            $data = [
                'message' => 'No hay actividades que incluyan en el nombre ' . $nombre,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'actividad' => $actividad_nombre,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta una actividad por su descripcion
     */
    public function actividadDescripcion($descripcion)
    {

        $actividad_descripcion = Actividade::where('descripcion', 'like', '%' . $descripcion . '%')->with('viaje')->paginate(10);

        if ($actividad_descripcion->isEmpty()) {
            $data = [
                'message' => 'No hay actividades con la descripcion ' . $descripcion,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'actividad' => $actividad_descripcion,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta una actividad por su direccion
     */
    public function actividadDireccion($direccion)
    {

        $actividad_direccion = Actividade::where('direccion_actividad', 'like', '%' . $direccion . '%')->with('viaje')->paginate(10);

        if ($actividad_direccion->isEmpty()) {
            $data = [
                'message' => 'No hay actividades en ' . $direccion,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'actividad' => $actividad_direccion,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta una actividad por su precio
     */
    public function actividadPrecio($precio)
    {

        $actividad_precio = Actividade::where('precio', 'like', '%' . $precio . '%')->with('viaje')->paginate(10);

        if ($actividad_precio->isEmpty()) {
            $data = [
                'message' => 'No hay actividades con un precio de ' . $precio,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'actividad' => $actividad_precio,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }
}
