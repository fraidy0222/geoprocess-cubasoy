<?php

namespace App\Http\Controllers\Api;

use App\Cultivo;
use App\Http\Controllers\Controller;
use App\Http\Resources\ValoresResource;
use App\Valores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = DB::table('valores')
        ->select(DB::raw('sum(venta_mes_cup) as diaria, sum(acumulado) as acumu'))
        ->get();

        return response()->json([
            'valores' => ValoresResource::collection(Valores::all()), 
            'cultivos' => Cultivo::pluck('name')->all(),
            'count' => $count
        ],200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cultivos = Cultivo::where('name', $request->cultivo)->first();
        $valores = Valores::create([
          'venta_diaria_cup' => $request->venta_diaria_cup,
          'venta_mes_cup' => $request->venta_mes_cup,
          'acumulado' => $request->acumulado,
        ]);
        $valores->cultivo()->associate($cultivos);
  
        $valores->save();
  
        return response()->json(['valores' => new ValoresResource($valores)], 200);
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
        $cultivos = Cultivo::where('name', $request->cultivo)->first();
        $valores = Valores::find($id);
        $valores->cultivo()->dissociate($cultivos);
        $valores->cultivo()->associate($cultivos);
        $valores->venta_diaria_cup = $request->venta_diaria_cup;
        $valores->venta_mes_cup = $request->venta_mes_cup;
        $valores->acumulado = $request->acumulado;

        $valores->save();
      
        return response()->json(['valores' => new ValoresResource($valores)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $valores = Valores::find($id)->delete();

        return response()->json(['valores' => $valores], 200);
    }
}
