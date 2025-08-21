<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Origene;
use App\Models\OrigenVuelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrigenVuelosController extends Controller
{

    /**
     * Nos devuelve todos los viajes de ida
     */
    public function obtenerOrigenes()
    {

        $destinos = OrigenVuelo::with('origene', 'vuelos')->paginate(10);

        $data = [
            'origenes' => $destinos,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
     * Funcion que nos crea el viaje de ida
     */
    public function crearOrigen(Request $datos_crear)
    {
        $validator = Validator::make($datos_crear->all(), [
            'origen_fk' => 'required|numeric',
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
            $viaje_comp = Origene::find($datos_crear->origen_fk);

            if (!$viaje_comp) {
                $data = [
                    'message' => 'El origen con ID ' . $datos_crear->origen_fk . ' no existe',
                    'status' => 404
                ];

                return response()->json($data, 404);
            } else {
                $viaje = OrigenVuelo::create([
                    "origen_fk" => $datos_crear->origen_fk,
                    "origen_terminal_salida" => $datos_crear->terminal_salida,
                    "origen_terminal_llegada" => $datos_crear->terminal_llegada,
                    "origen_salida" => $datos_crear->salida_fecha,
                    "origen_llegada" => $datos_crear->llegada_fecha,
                    "origen_vuelo" => $datos_crear->vuelo_nombre,
                    "origen_coste_vuelo" => $datos_crear->coste
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
     * Funcion que nos edita un viaje de ida
     */
    public function editarOrigen(Request $datos_editar, $id)
    {

        $origen_editar = OrigenVuelo::find($id);

        if (!$origen_editar) {
            $data = [
                'message' => 'No se encontró el viaje de ida con el ID' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $validator = Validator::make($datos_editar->all(), [
                'origen_fk' => 'required|numeric',
                'terminal_salida' => 'required|string',
                'terminal_llegada' => 'required|string',
                'salida_fecha' => 'required|string',
                'llegada_fecha' => 'required|string',
                'vuelo_nombre' => 'required|string',
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
                $viaje_comp = Origene::find($datos_editar->origen_fk);

                if (!$viaje_comp) {
                    $data = [
                        'message' => 'El origen con ID ' . $datos_editar->origen_fk . ' no existe',
                        'status' => 404
                    ];

                    return response()->json($data, 404);
                } else {
                    $origen_editar->origen_fk = $datos_editar->origen_fk;
                    $origen_editar->origen_terminal_salida = $datos_editar->terminal_salida;
                    $origen_editar->origen_terminal_llegada = $datos_editar->terminal_llegada;
                    $origen_editar->origen_salida = $datos_editar->salida_fecha;
                    $origen_editar->origen_llegada = $datos_editar->llegada_fecha;
                    $origen_editar->origen_vuelo = $datos_editar->vuelo_nombre;
                    $origen_editar->origen_coste_vuelo = $datos_editar->coste;
                    $origen_editar->save();

                    $data = [
                        'message' => 'Origen ' . $id . ' editado correctamente',
                        'status' => 200
                    ];

                    return response()->json($data, 200);
                }
            }
        }
    }

    /**
     * Funcion que nos elimina un viaje de ida en funcion de su ID
     */
    public function eliminarOrigen($id)
    {
        $viaje_eliminar = OrigenVuelo::find($id);

        if (!$viaje_eliminar) {
            $data = [
                'message' => 'No se pudo eliminar el viaje de ida con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $viaje_eliminar->delete();

            $data = [
                'message' => 'Viaje de ida eliminado correctamente',
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
        $vuelo = OrigenVuelo::with('origene', 'vuelos')->find($id);

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
        $vuelo = OrigenVuelo::where('origen_salida', 'like', '%' . $salida . '%')->with('origene', 'vuelos')->paginate(10);

        if ($vuelo->isEmpty()) {
            $data = [
                'message' => 'No se encontró el viaje de ida con fecha de salida: ' . $salida,
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
        $vuelo = OrigenVuelo::where('origen_llegada', 'like', '%' . $llegada . '%')->with('origene', 'vuelos')->paginate(10);

        if ($vuelo->isEmpty()) {
            $data = [
                'message' => 'No se encontró el viaje de ida con fecha de llegada: ' . $llegada,
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
