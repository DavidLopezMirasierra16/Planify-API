<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Moneda;
use Illuminate\Http\Request;

class MonedasController extends Controller
{
    /**
     * Funcion que nos devuelve todas las monedas
     */
    public function obtenerMonedas()
    {

        $monedas = Moneda::all();

        if ($monedas->isEmpty()) {
            $data = [
                'message' => 'No hay monedas registradas',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'monedas' => $monedas,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta una moneda por su id
     */
    public function monedasId($id)
    {

        $moneda = Moneda::find($id);

        if (!$moneda) {
            $data = [
                'message' => 'No hay monedas con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'moneda' => $moneda,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta una moneda por su nombre
     */
    public function monedasNombre($nombre)
    {

        $moneda_nombre = Moneda::where('nombre_moneda', 'like', '%' . $nombre . '%')->get();

        if ($moneda_nombre->isEmpty()) {
            $data = [
                'message' => 'No hay monedas con el nombre ' . $nombre,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'moneda' => $moneda_nombre,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }
}
