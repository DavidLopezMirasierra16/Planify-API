<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Itinerario;
use App\Models\Viaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItinerariosController extends Controller
{
    /**
     * Funcion que nos devuelve todos los itinerarios
     */
    public function obtenerItinerarios()
    {

        $itinerarios = Itinerario::with("viaje")->paginate(10);

        if ($itinerarios->isEmpty()) {
            $data = [
                'message' => 'No hay itinerarios guardados',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'itinerarios' => $itinerarios,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos crea un itinerario
     */
    public function crearItinerario(Request $datos_crear)
    {

        $validator = Validator::make($datos_crear->all(), [
            'id_viaje_fk' => 'required|numeric',
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'fecha_hora' => 'required',
            'ubicacion' => 'required|string'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        } else {
            $id_viaje = $datos_crear->id_viaje_fk;
            $viaje = Viaje::find($id_viaje);

            if (!$viaje) {
                $data = [
                    'message' => 'No se encontro el viaje con el id ' . $id_viaje,
                    'status' => 404
                ];

                return response()->json($data, 404);
            } else {
                $new_itinerario = Itinerario::create([
                    'id_viaje_fk' => $datos_crear->id_viaje_fk,
                    'nombre' => $datos_crear->nombre,
                    'descripcion' => $datos_crear->descripcion,
                    'fecha_hora' => $datos_crear->fecha_hora,
                    'ubicacion' => $datos_crear->ubicacion
                ]);

                $data = [
                    'message' => 'Itinerario creado con éxito',
                    'itinerario' => $new_itinerario,
                    'status' => 201
                ];

                return response()->json($data, 201);
            }
        }
    }

    /**
     * Funcion que nos edita un itinerario en funcion de su id
     */
    public function editarItinerario($id, Request $datos_editar)
    {

        $itinerario_editar = Itinerario::find($id);

        if (!$itinerario_editar) {
            $data = [
                'message' => 'No se encontro el itinerario con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $validator = Validator::make($datos_editar->all(), [
                'id_viaje_fk' => 'required|numeric',
                'nombre' => 'required|string',
                'descripcion' => 'required|string',
                'fecha_hora' => 'required',
                'ubicacion' => 'required|string'
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validacion',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {
                $id_viaje = $datos_editar->id_viaje_fk;
                $viaje = Viaje::find($id_viaje);

                if (!$viaje) {
                    $data = [
                        'message' => 'No se encontro el viaje con el id ' . $id_viaje,
                        'status' => 404
                    ];

                    return response()->json($data, 404);
                } else {
                    $itinerario_editar->id_viaje_fk = $datos_editar->id_viaje_fk;
                    $itinerario_editar->nombre = $datos_editar->nombre;
                    $itinerario_editar->descripcion = $datos_editar->descripcion;
                    $itinerario_editar->fecha_hora = $datos_editar->fecha_hora;
                    $itinerario_editar->ubicacion = $datos_editar->ubicacion;
                    $itinerario_editar->save();

                    $data = [
                        'message' => 'Itinerario con el id ' . $id . ' actualizado con éxito',
                        'itinerario' => $itinerario_editar,
                        'status' => 200
                    ];

                    return response()->json($data, 200);
                }
            }
        }
    }

    /**
     * Funcion que nos elimina un itinerario
     */
    public function eliminarItinerario($id)
    {

        $itinerario_eliminar = Itinerario::find($id);

        if (!$itinerario_eliminar) {
            $data = [
                'message' => 'No se pudo eliminar el itinerario ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $eliminar = $itinerario_eliminar->delete();

            if ($eliminar) {
                $data = [
                    'message' => 'Itinerario con el id ' . $id . ' eliminado correctamente',
                    'status' => 200
                ];

                return response()->json($data, 200);
            }
        }
    }

    //--------------------------------------CONSULTAS--------------------------------------

    /**
     * Funcion que nos consulta un itinerario por su id
     */
    public function itinerarioId($id)
    {

        $itinerario_id = Itinerario::with("viaje")->find($id);

        if (!$itinerario_id) {
            $data = [
                'message' => 'No hay ningun itinerario con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'itinerario' => $itinerario_id,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un itinerario por el id del viaje asignado
     */
    public function itinerarioViaje($id)
    {

        $viaje_id = Viaje::find($id);

        if (!$viaje_id) {
            $data = [
                'message' => 'No hay ningun viaje con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $itinerarios = Itinerario::where('id_viaje_fk', $viaje_id->id_viaje)->with("viaje")->paginate(10);

            if ($itinerarios->isEmpty()) {
                $data = [
                    'message' => 'No hay ningun itinerario con en el viaje numero ' . $id,
                    'status' => 404
                ];

                return response()->json($data, 404);
            } else {
                $data = [
                    'itinerario' => $itinerarios,
                    'status' => 200
                ];

                return response()->json($data, 200);
            }
        }
    }

    /**
     * Funcion que nos consulta un itinerario por su nombre
     */
    public function itinerarioNombre($nombre)
    {

        $itinerario_nombre = Itinerario::where('nombre', 'like', '%' . $nombre . '%')->with("viaje")->paginate(10);

        if ($itinerario_nombre->isEmpty()) {
            $data = [
                'message' => 'No hay ningun itinerario que contenga ' . $nombre . ' en el nombre',
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'itinerario' => $itinerario_nombre,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un itinerario por su descripcion
     */
    public function itinerarioDescripcion($descripcion)
    {

        $itinerario_descripcion = Itinerario::where('descripcion', 'like', '%' . $descripcion . '%')->with("viaje")->paginate(10);

        if ($itinerario_descripcion->isEmpty()) {
            $data = [
                'message' => 'No hay ningun itinerario que contenga ' . $descripcion . ' en la descripcion',
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'itinerario' => $itinerario_descripcion,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un itinerario por su fecha
     */
    public function itinerarioFecha($fecha)
    {

        $itinerario_fecha = Itinerario::where('fecha_hora', 'like', '%' . $fecha . '%')->with("viaje")->paginate(10);

        if ($itinerario_fecha->isEmpty()) {
            $data = [
                'message' => 'No hay ningun itinerario que contenga ' . $fecha . ' en la fecha',
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'itinerario' => $itinerario_fecha,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un itinerario por su ubicacion
     */
    public function itinerarioUbicacion($ubicacion)
    {

        $itinerario_ubicacion = Itinerario::where('ubicacion', 'like', '%' . $ubicacion . '%')->with("viaje")->paginate(10);

        if ($itinerario_ubicacion->isEmpty()) {
            $data = [
                'message' => 'No hay ningun itinerario que contenga ' . $ubicacion . ' en la ubicacion',
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'itinerario' => $itinerario_ubicacion,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }
}
