<?php

namespace App\Http\Controllers\Api;

use App\Cosecha;
use App\Cultivo;
use App\Http\Controllers\Controller;
use App\Http\Resources\CosechaResource;
use App\Ueb;
use Illuminate\Http\Request;

class CosechaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'cosechas' => CosechaResource::collection(Cosecha::all()),
            'uebs' => Ueb::pluck('name')->all(),
            'cultivo' => Cultivo::pluck('name')->all(),
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
        $cultivo = Cultivo::where('name', $request->cultivo)->first();
        $cosechas = Cosecha::create([
          'cc' => $request->cc,
          'area_total' => $request->area_total,
          'area' => $request->area,
          'a_c_diario' => $request->a_c_diario,
          'a_c_acum' => $request->a_c_acum,
          'a_c_pendiente' => $request->a_c_pendiente,
          't_diario' => $request->t_diario,
          't_acum' => $request->t_acum,
          't_rend' => $request->t_rend,
          'rend_acum' => $request->rend_acum,
          'arranque_m' => $request->arranque_m,
          'cant_equipos' => $request->cant_equipos,
        ]);
        $cosechas->ueb()->associate($ueb);
        $cosechas->cultivo()->associate($cultivo);
  
        $cosechas->save();
  
        return response()->json(['cosechas' => new CosechaResource($cosechas)], 200);
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
        $cultivo = Cultivo::where('name', $request->cultivo)->first();
        
        $cosechas = Cosecha::find($id);
        $cosechas->ueb()->dissociate($ueb);
        $cosechas->ueb()->associate($ueb);
        $cosechas->cultivo()->dissociate($cultivo);
        $cosechas->cultivo()->associate($cultivo);
        $cosechas->cc = $request->cc;
        $cosechas->area_total = $request->area_total;
        $cosechas->a_c_diario = $request->a_c_diario;
        $cosechas->a_c_acum = $request->a_c_acum;
        $cosechas->a_c_pendiente = $request->a_c_pendiente;
        $cosechas->t_diario = $request->t_diario;
        $cosechas->t_acum = $request->t_acum;
        $cosechas->t_rend = $request->t_rend;
        $cosechas->rend_acum = $request->rend_acum;
        $cosechas->arranque_m = $request->arranque_m;
        $cosechas->cant_equipos = $request->cant_equipos;
       
        $cosechas->save();
      
        return response()->json(['cosechas' => new CosechaResource($cosechas)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cosechas = Cosecha::find($id)->delete();

        return response()->json(['cosechas' => $cosechas], 200);
    }
}
