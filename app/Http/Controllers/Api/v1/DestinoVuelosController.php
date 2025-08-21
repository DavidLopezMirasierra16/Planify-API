<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Destino;
use App\Models\DestinoVuelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DestinoVuelosController extends Controller
{

    /**
     * Nos devuelve todos los viajes de vuelta
     */
    public function obtenerDestinos()
    {

        $destinos = DestinoVuelo::with('destino', 'vuelos')->paginate(10);

        $data = [
            'destinos' => $destinos,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
     * Funcion que nos crea el viaje de vuelta
     */
    public function crearDestino(Request $datos_crear)
    {
        $validator = Validator::make($datos_crear->all(), [
            'destino_fk' => 'required|numeric',
            'terminal_salida' => 'required|string',
            'terminal_llegada' => 'required|string',
            'salida_fecha' => 'required|string',
            'llegada_fecha' => 'required|string',
            'vuelo_nombre' => 'required|string',
            'coste' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        } else {
            $viaje_comp = Destino::find($datos_crear->destino_fk);

            if (!$viaje_comp) {
                $data = [
                    'message' => 'El destino con ID ' . $datos_crear->destino_fk . ' no existe',
                    'status' => 404
                ];

                return response()->json($data, 404);
            } else {
                $viaje = DestinoVuelo::create([
                    "destino_fk" => $datos_crear->destino_fk,
                    "destino_terminal_salida" => $datos_crear->terminal_salida,
                    "destino_terminal_llegada" => $datos_crear->terminal_llegada,
                    "destino_salida" => $datos_crear->salida_fecha,
                    "destino_llegada" => $datos_crear->llegada_fecha,
                    "destino_vuelo" => $datos_crear->vuelo_nombre,
                    "destino_coste_vuelo" => $datos_crear->coste
                ]);

                $data = [
                    'message' => 'Viaje de vuelta creado con éxito',
                    'destino' => $viaje, //Te devuelve el ID
                    'status' => 201
                ];

                return response()->json($data, 201);
            }
        }
    }

    /**
     * Funcion que nos edita un viaje de vuelta
     */
    public function editarDestino(Request $datos_editar, $id)
    {

        $destino_editar = DestinoVuelo::find($id);

        if (!$destino_editar) {
            $data = [
                'message' => 'No se encontró el viaje de vuelta con el ID' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $validator = Validator::make($datos_editar->all(), [
                'destino_fk' => 'required|numeric',
                'terminal_salida' => 'required|string',
                'terminal_llegada' => 'required|string',
                'salida' => 'required|string',
                'llegada' => 'required|string',
                'vuelo' => 'required|string',
                'coste' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validación',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {

                $viaje_comp = Destino::find($datos_editar->destino_fk);

                if (!$viaje_comp) {
                    $data = [
                        'message' => 'El destino con ID ' . $datos_editar->destino_fk . ' no existe',
                        'status' => 404
                    ];

                    return response()->json($data, 404);
                } else {
                    $destino_editar->destino_fk = $datos_editar->destino_fk;
                    $destino_editar->destino_terminal_salida = $datos_editar->terminal_salida;
                    $destino_editar->destino_terminal_llegada = $datos_editar->terminal_llegada;
                    $destino_editar->destino_salida = $datos_editar->salida;
                    $destino_editar->destino_llegada = $datos_editar->llegada;
                    $destino_editar->destino_vuelo = $datos_editar->vuelo;
                    $destino_editar->destino_coste_vuelo = $datos_editar->coste;
                    $destino_editar->save();

                    $data = [
                        'message' => 'Destino ' . $id . ' editado correctamente',
                        'status' => 200
                    ];

                    return response()->json($data, 200);
                }
            }
        }
    }

    /**
     * Funcion que nos elimina un viaje de vuelta en funcion de su ID
     */
    public function eliminarDestino($id)
    {
        $viaje_eliminar = DestinoVuelo::find($id);

        if (!$viaje_eliminar) {
            $data = [
                'message' => 'No se pudo eliminar el viaje de vuelta con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $viaje_eliminar->delete();

            $data = [
                'message' => 'Viaje de vuelta eliminado correctamente',
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    //--------------------------------------CONSULTAS--------------------------------------

    /**
     * Funcion que nos busca un vuelo de vuelta por su ID
     */
    public function vueloId($id)
    {
        $vuelo = DestinoVuelo::with('destino', 'vuelos')->find($id);

        if (!$vuelo) {
            $data = [
                'message' => 'No se encontró el viaje de vuelta con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'destino' => $vuelo,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta por la fecha de salida
     */
    public function vueloSalida($salida)
    {
        $vuelo = DestinoVuelo::where('destino_salida', 'like', '%' . $salida . '%')->paginate(10);

        if ($vuelo->isEmpty()) {
            $data = [
                'message' => 'No se encontró el viaje de vuelta con fecha de salida: ' . $salida,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'destino' => $vuelo,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta por la fecha de llegada
     */
    public function vueloLlegada($llegada)
    {
        $vuelo = DestinoVuelo::where('destino_llegada', 'like', '%' . $llegada . '%')->paginate(10);

        if ($vuelo->isEmpty()) {
            $data = [
                'message' => 'No se encontró el viaje de vuelta con fecha de llegada: ' . $llegada,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'destino' => $vuelo,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }
}
