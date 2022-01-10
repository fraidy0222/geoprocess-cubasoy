<?php

namespace App\Http\Controllers\Api;

use App\Energia;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncidenciaEnergiaResource;
use App\Http\Resources\IncidenciaMaquinaResource;
use App\IncidenciaEnergia;
use App\IncidenciaMaquina;
use App\Ueb;
use Illuminate\Http\Request;

class IncidenciasEnergiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'energia' => IncidenciaEnergiaResource::collection(IncidenciaEnergia::all()),
            'ueb' => Ueb::pluck('name')->all(),
            'plan_mes_energia' => Energia::pluck('plan_mes_energia')->all(),
            'plan_real_energia' => Energia::pluck('plan_real_energia')->all(),
            'porciento_energia' => Energia::pluck('porciento_energia')->all(),
            'plan_mes_petroleo' => Energia::pluck('plan_mes_petroleo')->all(),
            'plan_real_petroleo' => Energia::pluck('plan_real_petroleo')->all(),
            'porciento_petroleo' => Energia::pluck('porciento_petroleo')->all(),
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
        $plan_mes_energia = IncidenciaEnergia::where('plan_mes_energia', $request->energia)->first();
        $plan_real_energia = IncidenciaEnergia::where('plan_real_energia', $request->energia)->first();
        $porciento_energia = IncidenciaEnergia::where('porciento_energia', $request->energia)->first();
        $plan_mes_petroleo = IncidenciaEnergia::where('plan_mes_petroleo', $request->energia)->first();
        $plan_real_petroleo = IncidenciaEnergia::where('plan_real_petroleo', $request->energia)->first();
        $porciento_petroleo = IncidenciaEnergia::where('porciento_petroleo', $request->energia)->first();

        $datos = IncidenciaEnergia::create([
            'plan_mes_energia' => $request->plan_mes_energia,
            'plan_real_energia' => $request->plan_real_energia,
            'porciento_energia' => $request->porciento_energia,
            'plan_mes_petroleo' => $request->plan_mes_petroleo,
            'plan_real_petroleo' => $request->plan_real_petroleo,
            'porciento_petroleo' => $request->porciento_petroleo,
        ]);

        $datos->ueb()->associate($ueb);
        $datos->energia()->associate($plan_mes_energia);
        $datos->energia()->associate($plan_real_energia);
        $datos->energia()->associate($porciento_energia);
        $datos->energia()->associate($plan_mes_petroleo);
        $datos->energia()->associate($plan_real_petroleo);
        $datos->energia()->associate($porciento_petroleo);

        $datos->save();
        
        return response()->json(['incidencia_energia' => new IncidenciaEnergiaResource($datos)], 200);
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
        $plan_mes_energia = IncidenciaEnergia::where('plan_mes_energia', $request->energia)->first();
        $plan_real_energia = IncidenciaEnergia::where('plan_real_energia', $request->energia)->first();
        $porciento_energia = IncidenciaEnergia::where('porciento_energia', $request->energia)->first();
        $plan_mes_petroleo = IncidenciaEnergia::where('plan_mes_petroleo', $request->energia)->first();
        $plan_real_petroleo = IncidenciaEnergia::where('plan_real_petroleo', $request->energia)->first();
        $porciento_petroleo = IncidenciaEnergia::where('porciento_petroleo', $request->energia)->first();

        $datos = IncidenciaEnergia::find($id);

        $datos->ueb()->dissociate($ueb);
        $datos->ueb()->associate($ueb);
        $datos->energia()->associate($plan_mes_energia);
        $datos->energia()->dissociate($plan_mes_energia);
        $datos->energia()->associate($plan_real_energia);
        $datos->energia()->dissociate($plan_real_energia);
        $datos->energia()->associate($porciento_energia);
        $datos->energia()->dissociate($porciento_energia);
        $datos->energia()->associate($plan_mes_petroleo);
        $datos->energia()->dissociate($plan_mes_petroleo);
        $datos->energia()->associate($plan_real_petroleo);
        $datos->energia()->dissociate($plan_real_petroleo);
        $datos->energia()->associate($porciento_petroleo);
        $datos->energia()->dissociate($porciento_petroleo);

        $datos->plan_mes_energia = $request->plan_mes_energia;
        $datos->plan_real_energia = $request->plan_real_energia;
        $datos->porciento_energia = $request->porciento_energia;
        $datos->plan_mes_petroleo = $request->plan_mes_petroleo;
        $datos->plan_real_petroleo = $request->plan_real_petroleo;
        $datos->porciento_petroleo = $request->porciento_petroleo;
        
        $datos->save();

        return response()->json(['incidencia_energia' => new IncidenciaEnergiaResource($datos)], 200);
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
