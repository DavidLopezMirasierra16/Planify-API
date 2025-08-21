<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Idioma;
use Illuminate\Http\Request;

class IdiomasController extends Controller
{
    /**
     * Funcion que nos devuelve todos los idiomas
     */
    public function obtenerIdiomas()
    {

        $idiomas = Idioma::all();

        if ($idiomas->isEmpty()) {
            $data = [
                'message' => 'No hay idiomas registrados',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'idiomas' => $idiomas,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un idioma por su id
     */
    public function idiomaId($id)
    {

        $idioma = Idioma::find($id);

        if (!$idioma) {
            $data = [
                'message' => 'No hay idiomas con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'idioma' => $idioma,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }
}
