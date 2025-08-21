<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Origene;
use Illuminate\Http\Request;

class OrigenesController extends Controller
{
    /**
     * Funcion que nos devuelve todos los origenes
     */
    public function obtenerOrigenes()
    {

        $origenes = Origene::all();

        if ($origenes->isEmpty()) {
            $data = [
                'message' => 'No hay origenes guardados',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'origenes' => $origenes,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un origen por su id
     */
    public function origenesId($id)
    {

        $origen_id = Origene::with("viajes")->find($id);

        if (!$origen_id) {
            $data = [
                'message' => 'No hay ningun origen con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'origen' => $origen_id,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un origen por su nombre
     */
    public function origenesNombre($nombre)
    {

        $origen_nombre = Origene::where('ciudad', 'like', '%' . $nombre . '%')->with("viajes")->get();

        if ($origen_nombre->isEmpty()) {
            $data = [
                'message' => 'No hay origenes con el nombre ' . $nombre,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'origen' => $origen_nombre,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }
}
