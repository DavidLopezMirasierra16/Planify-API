<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Gasto;
use App\Models\Integrante;
use App\Models\Viaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GastosController extends Controller
{
    /**
     * Funcion que nos devuelve todos los gastos
     */
    public function obtenerGastos()
    {

        $gastos = Gasto::with('integrante')->paginate(10);

        if ($gastos->isEmpty()) {
            $data = [
                'message' => 'No hay gastos guardados',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {

            $data = [
                'gastos' => $gastos,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos crea un gasto
     */
    public function crearGasto(Request $datos_crear)
    {

        $validator = Validator::make($datos_crear->all(), [
            'valor' => 'required|numeric',
            'integrante_fk' => 'required|numeric',
            'pagado' => 'required|numeric|min:0|max:1',
            'descripcion' => 'nullable|max:45',
            'viaje_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        } else {
            $viaje = Viaje::find($datos_crear->viaje_id);

            if (!$viaje) {
                $data = [
                    'message' => 'No se encuentra el viaje con el id ' . $datos_crear->viaje_id,
                    'status' => 404
                ];

                return response()->json($data, 404);
            } else {
                $integrante = Integrante::where('id_integrante', $datos_crear->integrante_fk)
                    ->where('viaje_fk', $datos_crear->viaje_id)
                    ->first();

                if (!$integrante) {
                    $data = [
                        'message' => 'Ese integrante no está asociado a ese viaje',
                        'status' => 400
                    ];

                    return response()->json($data, 400);
                } else {
                    $new_gasto = Gasto::create([
                        'valor' => $datos_crear->valor,
                        'integrante_fk' => $datos_crear->integrante_fk,
                        'pagado' => $datos_crear->pagado,
                        'descripcion' => $datos_crear->descripcion,
                        'viaje_id' => $datos_crear->viaje_id
                    ]);

                    $data = [
                        'message' => 'Gasto creado con éxito',
                        'gasto' => $new_gasto,
                        'status' => 201
                    ];

                    return response()->json($data, 201);
                }
            }
        }
    }

    /**
     * Funcion que nos edita un gasto en funcion de su id
     */
    public function editarGasto($id, Request $datos_editar)
    {

        $gasto_editar = Gasto::find($id);

        if (!$gasto_editar) {
            $data = [
                'message' => 'No se encontro el gasto con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $validator = Validator::make($datos_editar->all(), [
                'valor' => 'required|numeric',
                'integrante_fk' => 'required|numeric',
                'pagado' => 'required|numeric|min:0|max:1',
                'descripcion' => 'nullable|max:45',
                'viaje_id' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validacion',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data, 400);
            } else {
                $viaje = Viaje::find($datos_editar->viaje_id);

                if (!$viaje) {
                    $data = [
                        'message' => 'No se encuentra el viaje con el id ' . $datos_editar->viaje_id,
                        'status' => 404
                    ];

                    return response()->json($data, 404);
                } else {
                    $integrante = Integrante::where('id_integrante', $datos_editar->integrante_fk)
                        ->where('viaje_fk', $datos_editar->viaje_id)
                        ->first();

                    if (!$integrante) {
                        $data = [
                            'message' => 'Ese integrante no está asociado a ese viaje',
                            'status' => 400
                        ];

                        return response()->json($data, 400);
                    } else {
                        $gasto_editar->valor = $datos_editar->valor;
                        $gasto_editar->integrante_fk = $datos_editar->integrante_fk;
                        $gasto_editar->pagado = $datos_editar->pagado;
                        $gasto_editar->descripcion = $datos_editar->descripcion;
                        $gasto_editar->viaje_id = $datos_editar->viaje_id;
                        $gasto_editar->save();

                        $data = [
                            'message' => 'Gasto con el id ' . $id . ' actualizado con éxito',
                            'status' => 200
                        ];

                        return response()->json($data, 200);
                    }
                }
            }
        }
    }

    /**
     * Funcion que nos elimina un gasto según su id
     */
    public function eliminarGasto($id)
    {

        $gasto_eliminar = Gasto::find($id);

        if (!$gasto_eliminar) {
            $data = [
                'message' => 'No se pudo eliminar el gasto número ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $eliminar = $gasto_eliminar->delete();

            if ($eliminar) {
                $data = [
                    'message' => 'Gasto número ' . $id . ' eliminado correctamente',
                    'status' => 200
                ];
            }

            return response()->json($data, 200);
        }
    }

    //--------------------------------------CONSULTAS--------------------------------------

    /**
     * Funcion que nos consulta un gasto por su id
     */
    public function gastoId($id)
    {

        $gasto_id = Gasto::with("integrante", "viaje")->find($id);

        if (!$gasto_id) {
            $data = [
                'message' => 'No hay ningun gasto con el id ' . $id,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'gasto' => $gasto_id,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un gasto por su valor
     */
    public function gastoValor($valor)
    {

        $gasto_valor = Gasto::where('valor', $valor)->with("integrante", "viaje")->paginate(10);

        if ($gasto_valor->isEmpty()) {
            $data = [
                'message' => 'No hay ningun gasto con el valor ' . $valor,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'gasto' => $gasto_valor,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un gasto por el integrante
     */
    public function gastoIntegrante($integrante)
    {

        $gasto_integrante = Gasto::where('integrante_fk', $integrante)->with("integrante", "viaje")->get();

        if ($gasto_integrante->isEmpty()) {
            $data = [
                'message' => 'No hay ningun gasto con el integrante ' . $integrante,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'gasto' => $gasto_integrante,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un gasto si esta pagado o no
     */
    public function gastoPagado($numero)
    {

        $gasto_pagado = Gasto::where('pagado', $numero)->with("integrante", "viaje")->paginate(10);

        if ($gasto_pagado->isEmpty()) {
            $data = [
                'message' => 'No hay ningun gasto pagado ' . $numero,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'gasto' => $gasto_pagado,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que nos consulta un gasto por la dscripcion
     */
    public function gastoDescripcion($descripcion)
    {

        $gasto_descripcion = Gasto::where('descripcion', 'like', '%' . $descripcion . '%')->with("integrante", "viaje")->paginate(10);

        if ($gasto_descripcion->isEmpty()) {
            $data = [
                'message' => 'No hay ningun gasto con la descripcion de ' . $descripcion,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'gasto' => $gasto_descripcion,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Funcion que le permite al usuario ver todos sus gastos
     */
    public function gastoUser(Request $request, $id)
    {

        if ($request->user()->id != $id) {
            $data = [
                'message' => 'No coincide el id con el tuyo',
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $gastos = Gasto::where('integrante_fk', $id)->get();

            $data = [
                'gastos' => $gastos,
                'status' => 200
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Función que nos obtiene los gastos de un viaje
     */
    public function gastoViaje($viaje) 
    {
        $gastos = Gasto::where('viaje_id', $viaje)->with("integrante", "viaje")->paginate(10);

        if ($gastos->isEmpty()) {
            $data = [
                'message' => 'No hay gastos en el viaje ' . $viaje,
                'status' => 404
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'gastos' => $gastos,
                'status' => 200
            ];

            return response()->json($data, 200);
        }

    }

}
