<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Hotele;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelesController extends Controller
{

    /**
     * Funcion que nos devuelve todos los hoteles
     */
    public function obtenerHoteles()
    {
        $hoteles = Hotele::with('viajes')->paginate(10);

        if (!$hoteles) {
            $data = [
                'message' => 'No hay hoteles guardados',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'hoteles' => $hoteles,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos registra un hotel
     */
    public function crearHotel(Request $datos_crear)
    {

        $validator = Validator::make($datos_crear->all(), [
            'nombre' => 'required',
            'info',
            'rating' => 'required|numeric',
            'proveedor' => 'required',
            'precio' => 'required|numeric',
            'url' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        } else {
            $hotel = new Hotele();
            $hotel->nombre = $datos_crear->nombre;
            $hotel->informacion = $datos_crear->info;
            $hotel->rating = $datos_crear->rating;
            $hotel->proveedor = $datos_crear->proveedor;
            $hotel->precio = $datos_crear->precio;
            $hotel->url_info = $datos_crear->url;
            $hotel->save();

            $data = [
                'message' => 'Hotel registrado con éxito',
                'hotel' => $hotel, //Te devuelve el ID
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos edita un hotel en funcion de su ID
     */
    public function editarHotel(Request $datos_editar, $id)
    {
        $hotel = Hotele::find($id);

        if (!$hotel) {
            $data = [
                'message' => 'No se encontró el hotel con el ID' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $validator = Validator::make($datos_editar->all(), [
                'nombre' => 'required',
                'info',
                'rating' => 'required|numeric',
                'proveedor' => 'required',
                'precio' => 'required|numeric',
                'url' => 'required'
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validación',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {
                $hotel->nombre = $datos_editar->nombre;
                $hotel->informacion = $datos_editar->info;
                $hotel->rating = $datos_editar->rating;
                $hotel->proveedor = $datos_editar->proveedor;
                $hotel->precio = $datos_editar->precio;
                $hotel->url_info = $datos_editar->url;
                $hotel->save();

                $data = [
                    'message' => 'Hotel con ID ' . $id . ' con éxito',
                    'hotel' => $hotel, //Te devuelve el ID
                    'status' => 200
                ];

                return response()->json($data, 200);
            }
        }
    }

    /**
     * Funcion que nos elimina un hotel
     */
    public function eliminarHotel($id)
    {
        $hotel_eliminar = Hotele::find($id);

        if (!$hotel_eliminar) {
            $data = [
                'message' => 'No se pudo eliminar el hotel con el ID ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $hotel_eliminar->delete();

            $data = [
                'message' => 'Hotel eliminado correctamente',
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    //--------------------------------------CONSULTAS--------------------------------------

    /**
     * Funcion que nos busca el hotel por su ID
     */
    public function hotelId($id)
    {
        $hotel = Hotele::with('viajes')->find($id);

        if (!$hotel) {
            $data = [
                'message' => 'No se encuentra el hotel con ID: ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'hotel' => $hotel,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos busca el hotel por su nombre
     */
    public function hotelNombre($nombre)
    {
        $hotel = Hotele::where('nombre', $nombre)->with('viajes')->paginate(10);

        if ($hotel->isEmpty()) {
            $data = [
                'message' => 'No se encuentra el hotel: ' . $nombre,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'hotel' => $hotel,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos busca el hotel por su informacion
     */
    public function hotelInfo($info)
    {
        $hotel = Hotele::where('informacion', 'like' . '%' . $info . '%')->with('viajes')->paginate(10);

        if ($hotel->isEmpty()) {
            $data = [
                'message' => 'No se encuentra el hotel con la informacion ' . $info,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'hotel' => $hotel,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos busca el hotel por su rating
     */
    public function hotelRating($rating)
    {
        $hotel = Hotele::where('rating', 'like', '%' . $rating . '%')->with('viajes')->paginate(10);

        if ($hotel->isEmpty()) {
            $data = [
                'message' => 'No se encuentra el hotel con el rating: ' . $rating,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'hotel' => $hotel,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos busca el hotel por su proveedor
     */
    public function hotelProveedor($proveedor)
    {
        $hotel = Hotele::where('proveedor', $proveedor)->with('viajes')->paginate(10);

        if ($hotel->isEmpty()) {
            $data = [
                'message' => 'No se encuentra el hotel con el proveedor: ' . $proveedor,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'hotel' => $hotel,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos busca el hotel por su precio
     */
    public function hotelPrecio($precio)
    {
        $hotel = Hotele::where('precio', 'like', '%' . $precio . '%')->with('viajes')->paginate(10);

        if ($hotel->isEmpty()) {
            $data = [
                'message' => 'No se encuentra el hotel con el precio: ' . $precio,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'hotel' => $hotel,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos busca el hotel por su url de informacion
     */
    public function hotelUrl($url)
    {
        $hotel = Hotele::where('url_info', $url)->with('viajes')->paginate(10);

        if ($hotel->isEmpty()) {
            $data = [
                'message' => 'No se encuentra el hotel con la url: ' . $url,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'hotel' => $hotel,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }
}
