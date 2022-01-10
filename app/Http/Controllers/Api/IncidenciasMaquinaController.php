<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IncidenciaMaquinaResource;
use App\IncidenciaMaquina;
use App\Maquinas;
use App\Ueb;
use Illuminate\Http\Request;

class IncidenciasMaquinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'maquina' => IncidenciaMaquinaResource::collection(IncidenciaMaquina::all()),
            'ueb' => Ueb::pluck('name')->all(),
            'total_maquinas_riego' => Maquinas::pluck('total_maquinas_riego')->all(),
            'maquinas_listas' => Maquinas::pluck('maquinas_listas')->all(),
            'afectaciones' => Maquinas::pluck('afectaciones')->all(),
            'maquinas_rotas' => Maquinas::pluck('maquinas_rotas')->all(),    
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
        $total_maquinas_riego = IncidenciaMaquina::where('total_maquinas_riego', $request->maquina)->first();
        $maquinas_listas = IncidenciaMaquina::where('maquinas_listas', $request->maquina)->first();
        $maquinas_rotas = IncidenciaMaquina::where('maquinas_rotas', $request->maquina)->first();
        $afectaciones = IncidenciaMaquina::where('afectaciones', $request->maquina)->first();

        $datos =  new IncidenciaMaquina();
        $datos->total_maquinas_riego = request('total_maquinas_riego');
        $datos->maquinas_listas = request('maquinas_listas');
        $datos->afectaciones = request('afectaciones');
        $datos->maquinas_rotas = request('maquinas_rotas');

        $datos->ueb()->associate($ueb);
        $datos->maquina()->associate($total_maquinas_riego);
        $datos->maquina()->associate($maquinas_listas);
        $datos->maquina()->associate($maquinas_rotas);
        $datos->maquina()->associate($afectaciones);

        $datos->save();

        return response()->json(['incidencia_maquina' => new IncidenciaMaquinaResource($datos)], 200);
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
        $total_maquinas_riego = IncidenciaMaquina::where('total_maquinas_riego', $request->maquina)->first();
        $maquinas_listas = IncidenciaMaquina::where('maquinas_listas', $request->maquina)->first();
        $maquinas_rotas = IncidenciaMaquina::where('maquinas_rotas', $request->maquina)->first();
        $afectaciones = IncidenciaMaquina::where('afectaciones', $request->maquina)->first();

        $datos = IncidenciaMaquina::find($id);

        $datos->ueb()->dissociate($ueb);
        $datos->ueb()->associate($ueb);
        $datos->maquina()->associate($total_maquinas_riego);
        $datos->maquina()->dissociate($total_maquinas_riego);
        $datos->maquina()->associate($maquinas_listas);
        $datos->maquina()->dissociate($maquinas_listas);
        $datos->maquina()->associate($maquinas_rotas);
        $datos->maquina()->dissociate($maquinas_rotas);
        $datos->maquina()->associate($afectaciones);
        $datos->maquina()->dissociate($afectaciones);

        $datos->total_maquinas_riego = request('total_maquinas_riego');
        $datos->maquinas_listas = request('maquinas_listas');
        $datos->afectaciones = request('afectaciones');
        $datos->maquinas_rotas = request('maquinas_rotas');

        $datos->save();

        return response()->json(['incidencia_maquina' => new IncidenciaMaquinaResource($datos)], 200);
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
