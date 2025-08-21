<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\DestinoVuelo;
use App\Models\OrigenVuelo;
use App\Models\Vuelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VuelosController extends Controller
{

    /**
     * Funcion que nos devuelve todos los vuelos
     */
    public function obtenerVuelos()
    {
        $vuelos = Vuelo::with('destino_vuelo', 'origen_vuelo', 'viajes')->paginate(10);

        $data = [
            'vuelos' => $vuelos,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
     * Funcion que nos crea un vuelo
     */
    public function crearVuelo(Request $datos_crear)
    {
        $validator = Validator::make($datos_crear->all(), [
            'vuelo_origen' => 'required|numeric',
            'vuelo_destino' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        } else {

            $destino = DestinoVuelo::find($datos_crear->vuelo_destino);
            $origen = OrigenVuelo::find($datos_crear->vuelo_origen);

            if (!$origen || !$destino) {
                $data = [
                    'message' => 'El vuelo de origen(ida) o el de destino(vuelta) no está almacenado',
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {

                $vuelo = new Vuelo();
                $vuelo->vuelo_origen = $datos_crear->vuelo_origen;
                $vuelo->vuelo_destino = $datos_crear->vuelo_destino;
                $vuelo->precio_vuelo_total = $origen->origen_coste_vuelo + $destino->destino_coste_vuelo;
                $vuelo->save();

                $data = [
                    'message' => 'Vuelo creado con éxito',
                    'vuelo' => $vuelo, //Te devuelve el ID
                    'status' => 201
                ];

                return response()->json($data, 201);
            }
        }
    }

    /**
     * Funcion que nos edita un vuelo
     */
    public function editarVuelo(Request $datos_editar, $id)
    {
        $vuelo = Vuelo::find($id);

        if (!$vuelo) {
            $data = [
                'message' => 'No se encontró el vuelo con el ID' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $validator = Validator::make($datos_editar->all(), [
                'vuelo_origen' => 'required|numeric',
                'vuelo_destino' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validacion',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {
                $destino = DestinoVuelo::find($datos_editar->vuelo_origen);
                $origen = OrigenVuelo::find($datos_editar->vuelo_destino);

                if (!$destino || !$origen) {
                    $data = [
                        'message' => 'El vuelo de origen(ida) o el de destino(vuelta) no está almacenado',
                        'status' => 400
                    ];

                    return response()->json($data, 400);
                } else {
                    $vuelo->vuelo_origen = $datos_editar->vuelo_origen;
                    $vuelo->vuelo_destino = $datos_editar->vuelo_destino;
                    $vuelo->precio_vuelo_total = $origen->origen_coste_vuelo + $destino->destino_coste_vuelo;
                    $vuelo->save();

                    $data = [
                        'message' => 'Vuelo ' . $id . ' editado correctamente',
                        'status' => 200
                    ];

                    return response()->json($data, 200);
                }
            }
        }
    }

    /**
     * Funcion que nos elimina un vuelo en función de su ID
     */
    public function eliminarVuelo($id)
    {
        $vuelo_eliminar = Vuelo::find($id);

        if (!$vuelo_eliminar) {
            $data = [
                'message' => 'No se pudo eliminar el vuelo con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $vuelo_eliminar->delete();

            $data = [
                'message' => 'Vuelo eliminado correctamente',
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    //--------------------------------------CONSULTAS--------------------------------------

    /**
     * Funcion que nos consulta por el id del vuelo
     */
    public function vueloId($id)
    {
        $vuelo = Vuelo::with('destino_vuelo', 'origen_vuelo', 'viajes')->find($id);

        if (!$vuelo) {
            $data = [
                'message' => 'No se encontró el vuelo con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'vuelo' => $vuelo,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta por el origen del vuelo
     */
    public function vueloOrigen($origen)
    {
        $vuelo = Vuelo::where('vuelo_origen', $origen)->with('destino_vuelo', 'origen_vuelo', 'viajes')->paginate(10);

        if ($vuelo->isEmpty()) {
            $data = [
                'message' => 'No se encontró el vuelo de ida con el origen número ' . $origen,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'vuelo' => $vuelo,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta por el destino del vuelo
     */
    public function vueloDestino($destino)
    {
        $vuelo = Vuelo::where('vuelo_destino', $destino)->with('destino_vuelo', 'origen_vuelo', 'viajes')->paginate(10);

        if ($vuelo->isEmpty()) {
            $data = [
                'message' => 'No se encontró el vuelo de vuelta con el origen número ' . $destino,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'vuelo' => $vuelo,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta por el precio del vuelo
     */
    public function vueloPrecio($precio)
    {
        $vuelo = Vuelo::where('precio_vuelo_total', 'like', '%' . $precio . '%')->with('destino_vuelo', 'origen_vuelo', 'viajes')->paginate(10);

        if ($vuelo->isEmpty()) {
            $data = [
                'message' => 'No se encontró el vuelo con precio ' . $precio,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'vuelo' => $vuelo,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }
}
