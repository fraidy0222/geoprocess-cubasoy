<?php

namespace App\Http\Controllers\Api;

use App\Cultivo;
use App\Http\Controllers\Controller;
use App\Http\Resources\ToneladasResource;
use App\Tonelada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToneladasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sum = DB::table('toneladas')
        ->select(DB::raw('
        sum(venta_d) as venta, 
        sum(acum_mes) as mes,
        sum(acum_fecha) as fecha,
        sum(acopio) as aco,
        sum(eam) as eam,
        sum(encarg_estatal) as estatal, 
        sum(industria) as indus, 
        sum(cayo_cruz) as cayo,
        sum(i_ceballos) as i,
        sum(fruta_select) as frutas,
        sum(otros) as otros,
        sum(semilla) as semilla,
        sum(es_camaguey) as cama
        '))
        ->get();

        return response()->json([
            'toneladas' => ToneladasResource::collection(Tonelada::all()), 
            'cultivos' => Cultivo::pluck('name')->all(),
            'sum' => $sum,
        ], 200);
    }
  
    public function store(Request $request)
    {
        $cultivos = Cultivo::where('name', $request->cultivo)->first();
        $toneladas = Tonelada::create([
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

        $toneladas->cultivo()->associate($cultivos);

        $toneladas->save();

        return response()->json(['toneladas' => new ToneladasResource($toneladas)], 200);
    }

    public function update(Request $request, $id)
    {
        $cultivos = Cultivo::where('name', $request->cultivo)->first();
        $toneladas = Tonelada::find($id);
        $toneladas->cultivo()->dissociate($cultivos);
        $toneladas->cultivo()->associate($cultivos);
        $toneladas->venta_d = $request->venta_d;
        $toneladas->acum_mes = $request->acum_mes;
        $toneladas->acum_fecha = $request->acum_fecha;
        $toneladas->acopio = $request->acopio;
        $toneladas->eam = $request->eam;
        $toneladas->encarg_estatal = $request->encarg_estatal;
        $toneladas->industria = $request->industria;
        $toneladas->cayo_cruz = $request->cayo_cruz;
        $toneladas->i_ceballos = $request->i_ceballos;
        $toneladas->fruta_select = $request->fruta_select;
        $toneladas->otros = $request->otros;
        $toneladas->semilla = $request->semilla;
        $toneladas->es_camaguey = $request->es_camaguey;

        $toneladas->save();

        return response()->json(['toneladas' => new ToneladasResource(($toneladas))], 200);
    }

    public function destroy($id)
    {
        $toneladas = Tonelada::find($id)->delete();

        return response()->json(['toneladas' => $toneladas]);
    }
}
