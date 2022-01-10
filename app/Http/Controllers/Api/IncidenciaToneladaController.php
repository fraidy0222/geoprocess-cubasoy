<?php

namespace App\Http\Controllers\Api;

use App\Cultivo;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncidenciaToneladaResource;
use App\IncidenciaTonelada;
use App\Tonelada;
use Illuminate\Http\Request;

class IncidenciaToneladaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'tonelada' => IncidenciaToneladaResource::collection(IncidenciaTonelada::all()),
            'cultivo' => Cultivo::pluck('name')->all(),
            'venta_d' => Tonelada::pluck('venta_d')->all(),
            'acum_mes' => Tonelada::pluck('acum_mes')->all(),
            'acum_fecha' => Tonelada::pluck('acum_fecha')->all(),
            'acopio' => Tonelada::pluck('acopio')->all(),
            'eam' => Tonelada::pluck('eam')->all(),
            'encarg_estatal' => Tonelada::pluck('encarg_estatal')->all(),
            'industria' => Tonelada::pluck('industria')->all(),
            'cayo_cruz' => Tonelada::pluck('cayo_cruz')->all(),
            'i_ceballos' => Tonelada::pluck('i_ceballos')->all(),
            'fruta_select' => Tonelada::pluck('fruta_select')->all(),
            'otros' => Tonelada::pluck('otros')->all(),
            'semilla' => Tonelada::pluck('semilla')->all(),
            'es_camaguey' => Tonelada::pluck('es_camaguey')->all(),
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
        $venta_d = IncidenciaTonelada::where('venta_d', $request->tonelada)->first();
        $acum_mes = IncidenciaTonelada::where('acum_mes', $request->tonelada)->first();
        $acum_fecha = IncidenciaTonelada::where('acum_fecha', $request->tonelada)->first();
        $acopio = IncidenciaTonelada::where('acopio', $request->tonelada)->first();
        $eam = IncidenciaTonelada::where('eam', $request->tonelada)->first();
        $encarg_estatal = IncidenciaTonelada::where('encarg_estatal', $request->tonelada)->first();
        $industria = IncidenciaTonelada::where('industria', $request->tonelada)->first();
        $cayo_cruz = IncidenciaTonelada::where('cayo_cruz', $request->tonelada)->first();
        $i_ceballos = IncidenciaTonelada::where('i_ceballos', $request->tonelada)->first();
        $fruta_select = IncidenciaTonelada::where('fruta_select', $request->tonelada)->first();
        $otros = IncidenciaTonelada::where('otros', $request->tonelada)->first();
        $semilla = IncidenciaTonelada::where('semilla', $request->tonelada)->first();
        $es_camaguey = IncidenciaTonelada::where('es_camaguey', $request->tonelada)->first();


        $datos = IncidenciaTonelada::create([
            'venta_d' => $request->venta_d,
            'acum_mes' => $request->acum_mes,
            'acum_fecha' => $request->acum_fecha,
            'acopio' => $request->acopio,
            'eam' => $request->eam,
            'encarg_estatal' => $request->encarg_estatal,
            'industria' => $request->industria,
            'cayo_cruz' => $request->cayo_cruz,
            'i_ceballos' => $request->i_ceballos,
            'fruta_select' => $request->fruta_select,
            'otros' => $request->otros,
            'semilla' => $request->semilla,
            'es_camaguey' => $request->es_camaguey,
        ]);

        $datos->cultivo()->associate($cultivo);
        $datos->tonelada()->associate($venta_d);
        $datos->tonelada()->associate($acum_mes);
        $datos->tonelada()->associate($acum_fecha);
        $datos->tonelada()->associate($acopio);
        $datos->tonelada()->associate($eam);
        $datos->tonelada()->associate($encarg_estatal);
        $datos->tonelada()->associate($industria);
        $datos->tonelada()->associate($cayo_cruz);
        $datos->tonelada()->associate($i_ceballos);
        $datos->tonelada()->associate($fruta_select);
        $datos->tonelada()->associate($otros);
        $datos->tonelada()->associate($semilla);
        $datos->tonelada()->associate($es_camaguey);

        $datos->save();
        
        return response()->json(['incidencia_toneladas' => new IncidenciaToneladaResource($datos)], 200);
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
        $venta_d = IncidenciaTonelada::where('venta_d', $request->tonelada)->first();
        $acum_mes = IncidenciaTonelada::where('acum_mes', $request->tonelada)->first();
        $acum_fecha = IncidenciaTonelada::where('acum_fecha', $request->tonelada)->first();
        $acopio = IncidenciaTonelada::where('acopio', $request->tonelada)->first();
        $eam = IncidenciaTonelada::where('eam', $request->tonelada)->first();
        $encarg_estatal = IncidenciaTonelada::where('encarg_estatal', $request->tonelada)->first();
        $industria = IncidenciaTonelada::where('industria', $request->tonelada)->first();
        $cayo_cruz = IncidenciaTonelada::where('cayo_cruz', $request->tonelada)->first();
        $i_ceballos = IncidenciaTonelada::where('i_ceballos', $request->tonelada)->first();
        $fruta_select = IncidenciaTonelada::where('fruta_select', $request->tonelada)->first();
        $otros = IncidenciaTonelada::where('otros', $request->tonelada)->first();
        $semilla = IncidenciaTonelada::where('semilla', $request->tonelada)->first();
        $es_camaguey = IncidenciaTonelada::where('es_camaguey', $request->tonelada)->first();
        
        $datos = IncidenciaTonelada::find($id);

        $datos->cultivo()->dissociate($cultivo);
        $datos->cultivo()->associate($cultivo);
        $datos->tonelada()->associate($venta_d);
        $datos->tonelada()->dissociate($venta_d);
        $datos->tonelada()->associate($acum_mes);
        $datos->tonelada()->dissociate($acum_mes);
        $datos->tonelada()->associate($acum_fecha);
        $datos->tonelada()->dissociate($acum_fecha);
        $datos->tonelada()->associate($acopio);
        $datos->tonelada()->dissociate($acopio);
        $datos->tonelada()->associate($eam);
        $datos->tonelada()->dissociate($eam);
        $datos->tonelada()->associate($encarg_estatal);
        $datos->tonelada()->dissociate($encarg_estatal);
        $datos->tonelada()->associate($industria);
        $datos->tonelada()->dissociate($industria);
        $datos->tonelada()->associate($cayo_cruz);
        $datos->tonelada()->dissociate($cayo_cruz);
        $datos->tonelada()->associate($i_ceballos);
        $datos->tonelada()->dissociate($i_ceballos);
        $datos->tonelada()->associate($fruta_select);
        $datos->tonelada()->dissociate($fruta_select);
        $datos->tonelada()->associate($otros);
        $datos->tonelada()->dissociate($otros);
        $datos->tonelada()->associate($semilla);
        $datos->tonelada()->dissociate($semilla);
        $datos->tonelada()->associate($es_camaguey);
        $datos->tonelada()->dissociate($es_camaguey);

        $datos->venta_d = $request->venta_d;
        $datos->acum_mes = $request->acum_mes;
        $datos->acum_fecha = $request->acum_fecha;
        $datos->acopio = $request->acopio;
        $datos->eam = $request->eam;
        $datos->encarg_estatal = $request->encarg_estatal;
        $datos->industria = $request->industria;
        $datos->cayo_cruz = $request->cayo_cruz;
        $datos->i_ceballos = $request->i_ceballos;
        $datos->fruta_select = $request->fruta_select;
        $datos->otros = $request->otros;
        $datos->semilla = $request->semilla;
        $datos->es_camaguey = $request->es_camaguey;

        $datos->save();
        return response()->json(['incidencia_tonelada' => new IncidenciaToneladaResource($datos)], 200);
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
