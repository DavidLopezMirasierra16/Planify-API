<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Destino;
use App\Models\Gasto;
use App\Models\Hotele;
use App\Models\Integrante;
use App\Models\Origene;
use App\Models\User;
use App\Models\Viaje;
use App\Models\Vuelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ViajesController extends Controller
{

    /**
     * Funcion que nos devuelve todos los viajes almacenados
     */
    public function obtenerViajes()
    {

        $viajes = Viaje::with('user_creador', 'destino', 'origene', 'actividades', 'gastos', 'integrantes', 'itinerarios', 'tareas', 'vuelo', 'hotele')->paginate(10);

        if ($viajes->isEmpty()) {
            $data = [
                'message' => 'No hay viajes guardados',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'viajes' => $viajes,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos crea un viaje
     */
    public function crearViajeNombre(Request $datos_crear)
    {

        $validator = Validator::make($datos_crear->all(), [
            'destino_fk' => 'required|string',
            'origen_fk' => 'required|string',
            'fecha_inicio' => 'required',
            'fecha_final' => 'required',
            'numero_integrantes' => 'required|numeric',
            'vuelo_fk' => 'required|numeric',
            'hotel_fk' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        } else {
            //Pillamos el origen y el destino
            $destino_viaje = Destino::where('ciudad_destino', $datos_crear->destino_fk)->first();
            $origen_viaje = Origene::where('ciudad', $datos_crear->origen_fk)->first();

            //Pillamos el vuelo y el hotel
            $vuelo = Vuelo::find($datos_crear->vuelo_fk);
            $hotel = Hotele::find($datos_crear->hotel_fk);

            if (!$destino_viaje || !$origen_viaje) {
                $data = [
                    'message' => "Destino u origen no almacenado",
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {

                if (!$vuelo || !$hotel) {
                    $data = [
                        'message' => "Vuelo u hotel no almacenado",
                        'status' => 400
                    ];

                    return response()->json($data, 400);
                } else {
                    $new_viaje = Viaje::create([
                        'destino_fk' => $destino_viaje->id_destino,
                        'origen_fk' => $origen_viaje->id_origen,
                        'fecha_inicio' => $datos_crear->fecha_inicio,
                        'fecha_final' => $datos_crear->fecha_final,
                        'numero_integrantes' => $datos_crear->numero_integrantes,
                        'vuelo_fk' => $datos_crear->vuelo_fk,
                        'hotel_fk' => $datos_crear->hotel_fk,
                        'total_hotel_vuelo' => $vuelo->precio_vuelo_total + $hotel->precio,
                        'id_creador_viaje' => $datos_crear->user()->id
                    ]);

                    if (!$new_viaje) {
                        $data = [
                            'message' => 'Error al crear el viaje',
                            'status' => 500
                        ];

                        return response()->json($data, 500);
                    } else {
                        $creador_viaje = Integrante::create([
                            'viaje_fk' => $new_viaje->id_viaje,
                            'nombre' => $datos_crear->user()->name,
                            'apellidos' => $datos_crear->user()->surnames,
                            //No se guarda la edad aposta (aparece null porque habría que cambiar la BD y es una movida), en el
                            //campo donde esté la edad en la aplicacion, se pone vacío.
                        ]);

                        if ($creador_viaje) {
                            $data = [
                                'message' => 'Viaje creado con éxito',
                                'viaje' => $new_viaje,
                                'status' => 201
                            ];

                            return response()->json($data, 201);
                        }
                    }
                }
            }
        }
    }

    /**
     * Funcion que nos crea un viaje por el ID de origen y destino
     */
    public function crearViajeId(Request $datos_crear)
    {

        $validator = Validator::make($datos_crear->all(), [
            'destino_fk' => 'required|numeric',
            'origen_fk' => 'required|numeric',
            'fecha_inicio' => 'required',
            'fecha_final' => 'required',
            'numero_integrantes' => 'required|numeric',
            'vuelo_fk' => 'required|numeric',
            'hotel_fk' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        } else {
            //Pillamos el origen y el destino
            $destino_viaje = Destino::find($datos_crear->destino_fk);
            $origen_viaje = Origene::find($datos_crear->origen_fk);

            //Pillamos el vuelo y el hotel
            $vuelo = Vuelo::find($datos_crear->vuelo_fk);
            $hotel = Hotele::find($datos_crear->hotel_fk);

            if (!$destino_viaje || !$origen_viaje) {
                $data = [
                    'message' => "Destino u origen no almacenado",
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {
                if (!$vuelo || !$hotel) {
                    $data = [
                        'message' => "Vuelo u hotel no almacenado",
                        'status' => 400
                    ];

                    return response()->json($data, 400);
                } else {
                    $new_viaje = Viaje::create([
                        'destino_fk' => $destino_viaje->id_destino,
                        'origen_fk' => $origen_viaje->id_origen,
                        'fecha_inicio' => $datos_crear->fecha_inicio,
                        'fecha_final' => $datos_crear->fecha_final,
                        'numero_integrantes' => $datos_crear->numero_integrantes,
                        'vuelo_fk' => $datos_crear->vuelo_fk,
                        'hotel_fk' => $datos_crear->hotel_fk,
                        'total_hotel_vuelo' => $vuelo->precio_vuelo_total + $hotel->precio,
                        'id_creador_viaje' => $datos_crear->user()->id
                    ]);

                    if (!$new_viaje) {
                        $data = [
                            'message' => 'Error al crear el viaje',
                            'status' => 500
                        ];

                        return response()->json($data, 500);
                    } else {
                        $creador_viaje = Integrante::create([
                            'viaje_fk' => $new_viaje->id_viaje,
                            'nombre' => $datos_crear->user()->name,
                            'apellidos' => $datos_crear->user()->surnames,
                            //No se guarda la edad aposta (aparece null porque habría que cambiar la BD y es una movida), en el
                            //campo donde esté la edad en la aplicacion, se pone vacío.
                        ]);

                        if ($creador_viaje) {
                            $data = [
                                'message' => 'Viaje creado con éxito',
                                'viaje' => $new_viaje,
                                'status' => 201
                            ];

                            return response()->json($data, 201);
                        }
                    }
                }
            }
        }
    }

    /**
     * Funcion que nos actualiza un viaje según su id mediante
     * el nombre del destino y origen
     */
    public function editarViajeNombre($id, Request $datos_editar)
    {

        $viaje_editar = Viaje::find($id);

        if (!$viaje_editar) {
            $data = [
                'message' => 'No se encontro el viaje con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $validator = Validator::make($datos_editar->all(), [
                'destino_fk' => 'required|string',
                'origen_fk' => 'required|string',
                'fecha_inicio' => 'required',
                'fecha_final' => 'required',
                'numero_integrantes' => 'required|numeric',
                'vuelo_fk' => 'required|numeric',
                'hotel_fk' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validacion',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {
                //Pillamos el origen y el destino
                $destino_viaje = Destino::where('ciudad_destino', $datos_editar->destino_fk)->first();
                $origen_viaje = Origene::where('ciudad', $datos_editar->origen_fk)->first();

                //Pillamos el vuelo y el hotel
                $vuelo = Vuelo::find($datos_editar->vuelo_fk);
                $hotel = Hotele::find($datos_editar->hotel_fk);

                if (!$destino_viaje || !$origen_viaje) {
                    $data = [
                        'message' => "Destino o viaje no almacenado",
                        'status' => 400
                    ];

                    return response()->json($data, 400);
                } else {
                    if (!$vuelo || !$hotel) {
                        $data = [
                            'message' => "Vuelo u hotel no almacenado",
                            'status' => 400
                        ];

                        return response()->json($data, 400);
                    } else {
                        $viaje_editar->destino_fk = $destino_viaje->id_destino;
                        $viaje_editar->origen_fk = $origen_viaje->id_origen;
                        $viaje_editar->fecha_inicio = $datos_editar->fecha_inicio;
                        $viaje_editar->fecha_final = $datos_editar->fecha_final;
                        $viaje_editar->numero_integrantes = $datos_editar->numero_integrantes;
                        $viaje_editar->vuelo_fk = $datos_editar->vuelo_fk;
                        $viaje_editar->hotel_fk = $datos_editar->hotel_fk;
                        $viaje_editar->total_hotel_vuelo = $vuelo->precio_vuelo_total + $hotel->precio;
                        $viaje_editar->id_creador_viaje = $datos_editar->user()->id;
                        $viaje_editar->save();

                        $data = [
                            'message' => 'Viaje con el id ' . $id . ' actualizado con éxito',
                            'status' => 200
                        ];

                        return response()->json($data, 200);
                    }
                }
            }
        }
    }

    /**
     * Funcion que nos actualiza un viaje según su id mediante
     * el id del destino y el origen
     */
    public function editarViajeId($id, Request $datos_editar)
    {

        $viaje_editar = Viaje::find($id);

        if (!$viaje_editar) {
            $data = [
                'message' => 'No se encontro el viaje con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $validator = Validator::make($datos_editar->all(), [
                'destino_fk' => 'required|numeric',
                'origen_fk' => 'required|numeric',
                'fecha_inicio' => 'required',
                'fecha_final' => 'required',
                'numero_integrantes' => 'required|numeric',
                'vuelo_fk' => 'required|numeric',
                'hotel_fk' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validacion',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {
                //Pillamos el origen y el destino
                $destino_viaje = Destino::find($datos_editar->destino_fk);
                $origen_viaje = Origene::find($datos_editar->origen_fk);

                //Pillamos el vuelo y el hotel
                $vuelo = Vuelo::find($datos_editar->vuelo_fk);
                $hotel = Hotele::find($datos_editar->hotel_fk);

                if (!$destino_viaje || !$origen_viaje) {
                    $data = [
                        'message' => "Destino u origen no almacenado",
                        'status' => 400
                    ];

                    return response()->json($data, 400);
                } else {
                    if (!$vuelo || !$hotel) {
                        $data = [
                            'message' => "Vuelo u hotel no almacenado",
                            'status' => 400
                        ];

                        return response()->json($data, 400);
                    } else {
                        $viaje_editar->destino_fk = $datos_editar->destino_fk;
                        $viaje_editar->origen_fk = $datos_editar->origen_fk;
                        $viaje_editar->fecha_inicio = $datos_editar->fecha_inicio;
                        $viaje_editar->fecha_final = $datos_editar->fecha_final;
                        $viaje_editar->numero_integrantes = $datos_editar->numero_integrantes;
                        $viaje_editar->vuelo_fk = $datos_editar->vuelo_fk;
                        $viaje_editar->hotel_fk = $datos_editar->hotel_fk;
                        $viaje_editar->total_hotel_vuelo = $vuelo->precio_vuelo_total + $hotel->precio;
                        $viaje_editar->id_creador_viaje = $datos_editar->user()->id;
                        $viaje_editar->save();

                        $data = [
                            'message' => 'Viaje con el id ' . $id . ' actualizado con éxito',
                            'status' => 200
                        ];

                        return response()->json($data, 200);
                    }
                }
            }
        }
    }

    /**
     * Funcion que nos elimina un viaje según su id
     */
    public function eliminarViaje($id)
    {

        $viaje_eliminar = Viaje::find($id);

        if (!$viaje_eliminar) {
            $data = [
                'message' => 'No se pudo eliminar el viaje numero ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $eliminar = $viaje_eliminar->delete();

            if ($eliminar) {
                $data = [
                    'message' => 'Viaje con el id ' . $id . ' eliminada correctamente',
                    'status' => 200
                ];
            }

            return response()->json($data, 200);
        }
    }

    //--------------------------------------CONSULTAS--------------------------------------

    /**
     * Funcion que nos consulta un viaje por su id
     */
    public function viajeId($id)
    {

        $viaje_id = Viaje::with('user_creador', 'destino', 'origene', 'actividades', 'gastos', 'integrantes', 'itinerarios', 'tareas', 'vuelo', 'hotele')->find($id);

        if (!$viaje_id) {
            $data = [
                'message' => 'No hay ningun viaje con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'viaje' => $viaje_id,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un viaje por el id del destino
     */
    public function viajeDestinoId($id)
    {

        $destino_id = Viaje::where('destino_fk', $id)->with('user_creador', 'destino', 'origene', 'actividades', 'gastos', 'integrantes', 'itinerarios', 'tareas', 'vuelo', 'hotele')->paginate(10);

        if ($destino_id->isEmpty()) {
            $data = [
                'message' => 'No hay ningun viaje con el destino ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'viaje' => $destino_id,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un viaje por el nombre del destino
     */
    public function viajeDestinoNombre($nombre)
    {

        $destino_nombre = Destino::where('ciudad_destino', $nombre)->first();

        if (!$destino_nombre) {
            $data = [
                'message' => 'No hay ningun destino llamado ' . $nombre,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $id = $destino_nombre->id_destino;

            $destino_final = Viaje::where('destino_fk', $id)->with('user_creador', 'destino', 'origene', 'actividades', 'gastos', 'integrantes', 'itinerarios', 'tareas', 'vuelo', 'hotele')->paginate(10);

            if ($destino_final->isEmpty()) {
                $data = [
                    'message' => 'No hay ningun viaje en ' . $nombre,
                    'status' => 404
                ];

                return response()->json($data, 404);
            } else {
                $data = [
                    'viaje' => $destino_final,
                    'status' => 200
                ];

                return response()->json($data, 200);
            }
        }
    }

    /**
     * Funcion que nos consulta un viaje por el id del origen
     */
    public function viajeOrigenId($id)
    {

        $origen_id = Viaje::where('origen_fk', $id)->with('user_creador', 'destino', 'origene', 'actividades', 'gastos', 'integrantes', 'itinerarios', 'tareas', 'vuelo', 'hotele')->paginate(10);

        if ($origen_id->isEmpty()) {
            $data = [
                'message' => 'No hay ningun viaje con el origen ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'viaje' => $origen_id,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un viaje por el nombre del destino
     */
    public function viajeOrigenNombre($nombre)
    {

        $origen_nombre = Destino::where('ciudad_destino', $nombre)->first();

        if (!$origen_nombre) {
            $data = [
                'message' => 'No hay ningun origen llamado ' . $nombre,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $id = $origen_nombre->id_destino;

            $origen_final = Viaje::where('origen_fk', '=', $id)->with('user_creador', 'destino', 'origene', 'actividades', 'gastos', 'integrantes', 'itinerarios', 'tareas', 'vuelo', 'hotele')->paginate(10);

            if ($origen_final->isEmpty()) {
                $data = [
                    'message' => 'No hay ningun viaje en ' . $nombre,
                    'status' => 404
                ];

                return response()->json($data, 404);
            } else {
                $data = [
                    'viaje' => $origen_final,
                    'status' => 200
                ];

                return response()->json($data, 200);
            }
        }
    }

    /**
     * Funcion que nos consulta un viaje por la fecha de llegada
     */
    public function viajeLlegada($fecha)
    {

        // $fecha_busqueda = Viaje::whereRaw('SUBSTRING(fecha_inicio, 1, 10) = ?', [$fecha])->get();
        $fecha_busqueda = Viaje::where('fecha_inicio', 'like', '%' . $fecha . '%')->with('user_creador', 'destino', 'origene', 'actividades', 'gastos', 'integrantes', 'itinerarios', 'tareas', 'vuelo', 'hotele')->paginate(10);

        if ($fecha_busqueda->isEmpty()) {
            $data = [
                'message' => 'No hay ningun viaje con ' . $fecha . ' como fecha de inicio',
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'viaje' => $fecha_busqueda,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un viaje por la fecha de finalizacion
     */
    public function viajeSalida($fecha)
    {

        // $fecha_busqueda = Viaje::whereRaw('SUBSTRING(fecha_final, 1, 10) = ?', [$fecha])->get();
        $fecha_busqueda = Viaje::where('fecha_final', 'like', '%' . $fecha . '%')->with('user_creador', 'destino', 'origene', 'actividades', 'gastos', 'integrantes', 'itinerarios', 'tareas', 'vuelo', 'hotele')->paginate(10);

        if ($fecha_busqueda->isEmpty()) {
            $data = [
                'message' => 'No hay ningun viaje con ' . $fecha . ' como fecha de finalización',
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'viaje' => $fecha_busqueda,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un viaje por el numero de integrantes
     */
    public function viajeIntegrantes($integrantes)
    {

        $integrantes_viaje = Viaje::where('numero_integrantes', $integrantes)->with('user_creador', 'destino', 'origene', 'actividades', 'gastos', 'integrantes', 'itinerarios', 'tareas', 'vuelo', 'hotele')->paginate(10);

        if ($integrantes_viaje->isEmpty()) {
            $data = [
                'message' => 'No hay ningun viaje con ' . $integrantes . ' integrante/s',
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'viaje' => $integrantes_viaje,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Fucion que nos consulta todos los viajes del usuario logeado
     */
    public function viajeUser(Request $request, $id)
    {
        if ($request->user()->id != $id) {
            $data = [
                'message' => 'No coincide el id con el tuyo',
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $viajes = Viaje::where('id_creador_viaje', $id)->with('user_creador', 'destino', 'origene', 'actividades', 'gastos', 'integrantes', 'itinerarios', 'tareas', 'vuelo', 'hotele')->get();

            $data = [
                'viajes' => $viajes,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }
}
