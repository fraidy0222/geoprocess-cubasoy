<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IncideniciaQuimicosResource;
use App\IncidenciaQuimico;
use App\Quimico;
use App\Ueb;
use Illuminate\Http\Request;

class IncidenciaQuimiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'quimicos' => IncideniciaQuimicosResource::collection(IncidenciaQuimico::all()),
            'ueb' => Ueb::pluck('name')->all(),
            'cc' => Quimico::pluck('cc')->all(),
            'tipo_aplicacion' => Quimico::pluck('tipo_aplicacion')->all(),
            'tipo_producto' => Quimico::pluck('tipo_producto')->all(),
            'cant' => Quimico::pluck('cant')->all(),    
            'cant_equipos' => Quimico::pluck('cant_equipos')->all(),    
            'area_aplicada' => Quimico::pluck('area_aplicada')->all(),    
            'area_acum' => Quimico::pluck('area_acum')->all(),    
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
        $ueb = Ueb::where('name', $request->ueb)->first();
        $cc = IncidenciaQuimico::where('cc', $request->maquina)->first();
        $tipo_aplicacion = IncidenciaQuimico::where('tipo_aplicacion', $request->maquina)->first();
        $tipo_producto = IncidenciaQuimico::where('tipo_producto', $request->maquina)->first();
        $cant = IncidenciaQuimico::where('cant', $request->maquina)->first();
        $cant_equipos = IncidenciaQuimico::where('cant_equipos', $request->maquina)->first();
        $area_aplicada = IncidenciaQuimico::where('area_aplicada', $request->maquina)->first();
        $area_acum = IncidenciaQuimico::where('area_acum', $request->maquina)->first();

        $datos = IncidenciaQuimico::create([
            'cc' => $request->cc,
            'tipo_aplicacion' => $request->tipo_aplicacion,
            'tipo_producto' => $request->tipo_producto,
            'cant' => $request->cant,
            'cant_equipos' => $request->cant_equipos,
            'area_aplicada' => $request->area_aplicada,
            'area_acum' => $request->area_acum
        ]);

        $datos->ueb()->associate($ueb);
        $datos->quimico()->associate($cc);
        $datos->quimico()->associate($tipo_aplicacion);
        $datos->quimico()->associate($tipo_producto);
        $datos->quimico()->associate($cant_equipos);
        $datos->quimico()->associate($area_aplicada);
        $datos->quimico()->associate($area_acum);
        $datos->quimico()->associate($cant);

        $datos->save();

        return response()->json(['incidencia_quimico' => new IncideniciaQuimicosResource($datos)], 200);
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
        $ueb = Ueb::where('name', $request->ueb)->first();
        $cc = IncidenciaQuimico::where('cc', $request->cultivo)->first();
        $tipo_aplicacion = IncidenciaQuimico::where('tipo_aplicacion', $request->cultivo)->first();
        $tipo_producto = IncidenciaQuimico::where('tipo_producto', $request->cultivo)->first();
        $cant = IncidenciaQuimico::where('cant', $request->cultivo)->first();
        $cant_equipos = IncidenciaQuimico::where('cant_equipos', $request->cultivo)->first();
        $area_aplicada = IncidenciaQuimico::where('area_aplicada', $request->cultivo)->first();
        $area_acum = IncidenciaQuimico::where('area_acum', $request->cultivo)->first();

        $datos = IncidenciaQuimico::find($id);

        $datos->ueb()->dissociate($ueb);
        $datos->ueb()->associate($ueb);
        $datos->quimico()->associate($cc);
        $datos->quimico()->dissociate($cc);
        $datos->quimico()->associate($tipo_aplicacion);
        $datos->quimico()->dissociate($tipo_aplicacion);
        $datos->quimico()->associate($tipo_producto);
        $datos->quimico()->dissociate($tipo_producto);
        $datos->quimico()->associate($cant_equipos);
        $datos->quimico()->dissociate($cant_equipos);
        $datos->quimico()->associate($area_aplicada);
        $datos->quimico()->dissociate($area_aplicada);
        $datos->quimico()->associate($area_acum);
        $datos->quimico()->dissociate($area_acum);
        $datos->quimico()->associate($cant);
        $datos->quimico()->dissociate($cant);

        $datos->cc = $request->cc;
        $datos->tipo_aplicacion = $request->tipo_aplicacion;
        $datos->tipo_producto = $request->tipo_producto;
        $datos->cant = $request->cant;
        $datos->cant_equipos = $request->cant_equipos;
        $datos->area_aplicada = $request->area_aplicada;
        $datos->area_acum = $request->area_acum;
      
        $datos->save();

        return response()->json(['incidencia_quimico' => new IncideniciaQuimicosResource($datos)], 200);
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
