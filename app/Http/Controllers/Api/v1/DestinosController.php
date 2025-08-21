<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Destino;
use Illuminate\Http\Request;

class DestinosController extends Controller
{
    /**
     * Funcion que nos devuelve todos los destinos
     */
    public function obtenerDestinos()
    {

        $destinos = Destino::all();

        if ($destinos->isEmpty()) {
            $data = [
                'message' => 'No hay destinos guardados',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'destinos' => $destinos,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un destino por su id
     */
    public function destinoId($id)
    {

        $destino_id = Destino::with("viajes")->find($id);

        if (!$destino_id) {
            $data = [
                'message' => 'No hay ningun destino con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'destino' => $destino_id,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un destino por su nombre
     */
    public function destinoNombre($nombre)
    {

        $destino_nombre = Destino::where('ciudad_destino', 'like', '%' . $nombre . '%')->with("viajes")->get();

        if ($destino_nombre->isEmpty()) {
            $data = [
                'message' => 'No hay destinos con el nombre ' . $nombre,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'destino' => $destino_nombre,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }
}
