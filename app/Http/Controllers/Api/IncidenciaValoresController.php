<?php

namespace App\Http\Controllers\Api;

use App\Cultivo;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncidenciasValoresResource;
use App\IncidenciasValore;
use App\Valores;
use Illuminate\Http\Request;

class IncidenciaValoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'valores' => IncidenciasValoresResource::collection(IncidenciasValore::all()),
            'cultivo' => Cultivo::pluck('name')->all(),
            'venta_diaria_cup' => Valores::pluck('venta_diaria_cup')->all(),
            'venta_mes_cup' => Valores::pluck('venta_mes_cup')->all(),
            'acumulado' => Valores::pluck('acumulado')->all(),
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cultivo = Cultivo::where('name', $request->cultivo)->first();
        $venta_diaria_cup = IncidenciasValore::where('venta_diaria_cup', $request->valore)->first();
        $venta_mes_cup = IncidenciasValore::where('venta_mes_cup', $request->valore)->first();
        $acumulado = IncidenciasValore::where('acumulado', $request->valore)->first();

        $datos = IncidenciasValore::create([
            'venta_diaria_cup' => $request->venta_diaria_cup,
            'venta_mes_cup' => $request->venta_mes_cup,
            'acumulado' => $request->acumulado,
        ]);

        $datos->cultivo()->associate($cultivo);
        $datos->valore()->associate($venta_diaria_cup);
        $datos->valore()->associate($venta_mes_cup);
        $datos->valore()->associate($acumulado);

        $datos->save();
        
        return response()->json(['incidencia_valore' => new IncidenciasValoresResource($datos)], 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cultivo = Cultivo::where('name', $request->cultivo)->first();
        $venta_diaria_cup = IncidenciasValore::where('venta_diaria_cup', $request->valore)->first();
        $venta_mes_cup = IncidenciasValore::where('venta_mes_cup', $request->valore)->first();
        $acumulado = IncidenciasValore::where('acumulado', $request->valore)->first();

        $datos = IncidenciasValore::find($id);

        $datos->cultivo()->dissociate($cultivo);
        $datos->cultivo()->associate($cultivo);
        $datos->valore()->associate($venta_diaria_cup);
        $datos->valore()->dissociate($venta_diaria_cup);
        $datos->valore()->associate($venta_mes_cup);
        $datos->valore()->dissociate($venta_mes_cup);
        $datos->valore()->associate($acumulado);
        $datos->valore()->dissociate($acumulado);

        $datos->venta_diaria_cup = $request->venta_diaria_cup;
        $datos->venta_diaria_cup = $request->venta_diaria_cup;
        $datos->acumulado  = $request->acumulado;

        $datos->save();

        return response()->json(['incidencia_valore' => new IncidenciasValoresResource($datos)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
