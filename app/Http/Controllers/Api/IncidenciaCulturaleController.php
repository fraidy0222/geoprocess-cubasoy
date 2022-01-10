<?php

namespace App\Http\Controllers\Api;

use App\Cultivo;
use App\Culturale;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncidenciaCulturaleResource;
use App\IncidenciaCulturale;
use App\Ueb;
use Illuminate\Http\Request;

class IncidenciaCulturaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'culturale' => IncidenciaCulturaleResource::collection(IncidenciaCulturale::all()),
            'ueb' => Ueb::pluck('name')->all(),
            'cultivo' => Cultivo::pluck('name')->all(),
            'cc' => Culturale::pluck('cc')->all(),
            'tipo_peloton' => Culturale::pluck('tipo_peloton')->all(),
            'c_plan' => Culturale::pluck('c_plan')->all(),
            'c_acum' => Culturale::pluck('c_acum')->all(),
            'c_diario' => Culturale::pluck('c_diario')->all(),
            'p_plan' => Culturale::pluck('p_plan')->all(),
            'p_acum' => Culturale::pluck('p_acum')->all(),
            'p_diario' => Culturale::pluck('p_diario')->all(),
            'l_plan' => Culturale::pluck('l_plan')->all(),
            'l_acum' => Culturale::pluck('l_acum')->all(),
            'l_diario' => Culturale::pluck('l_diario')->all(),
            'ch_plan' => Culturale::pluck('ch_plan')->all(),
            'ch_acum' => Culturale::pluck('ch_acum')->all(),
            'ch_diario' => Culturale::pluck('ch_diario')->all(),
            'd_d' => Culturale::pluck('d_d')->all(),
           
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
        $ueb = Ueb::where('name', $request->ueb)->first();
        $c_plan = IncidenciaCulturale::where('c_plan', $request->culturale)->first();
        $c_acum = IncidenciaCulturale::where('c_acum', $request->culturale)->first();
        $c_diario = IncidenciaCulturale::where('c_diario', $request->culturale)->first();
        $p_plan = IncidenciaCulturale::where('p_plan', $request->culturale)->first();
        $p_acum = IncidenciaCulturale::where('p_acum', $request->culturale)->first();
        $p_diario = IncidenciaCulturale::where('p_diario', $request->culturale)->first();
        $l_plan = IncidenciaCulturale::where('l_plan', $request->culturale)->first();
        $l_acum = IncidenciaCulturale::where('l_acum', $request->culturale)->first();
        $l_diario = IncidenciaCulturale::where('l_diario', $request->culturale)->first();
        $ch_plan = IncidenciaCulturale::where('ch_plan', $request->culturale)->first();
        $ch_acum = IncidenciaCulturale::where('ch_acum', $request->culturale)->first();
        $ch_diario = IncidenciaCulturale::where('ch_diario', $request->culturale)->first();
        $d_d = IncidenciaCulturale::where('d_d', $request->culturale)->first();
        $cc = IncidenciaCulturale::where('cc', $request->culturale)->first();
        $tipo_peloton = IncidenciaCulturale::where('tipo_peloton', $request->culturale)->first();

        $datos = IncidenciaCulturale::create([
            'c_plan' => $request->c_plan,
            'c_acum' => $request->c_acum,
            'c_diario' => $request->c_diario,
            'p_plan' => $request->p_plan,
            'p_acum' => $request->p_acum,
            'p_diario' => $request->p_diario,
            'l_plan' => $request->l_plan,
            'l_acum' => $request->l_acum,
            'l_diario' => $request->l_diario,
            'ch_plan' => $request->ch_plan,
            'ch_acum' => $request->ch_acum,
            'ch_diario' => $request->ch_diario,
            'd_d' => $request->d_d,
            'cc' => $request->cc,
            'tipo_peloton' => $request->tipo_peloton,
        ]);

        $datos->ueb()->associate($ueb);
        $datos->cultivo()->associate($cultivo);
        $datos->culturale()->associate($c_plan);
        $datos->culturale()->associate($c_acum);
        $datos->culturale()->associate($c_diario);
        $datos->culturale()->associate($p_plan);
        $datos->culturale()->associate($p_acum);
        $datos->culturale()->associate($p_diario);
        $datos->culturale()->associate($l_plan);
        $datos->culturale()->associate($l_acum);
        $datos->culturale()->associate($l_diario);
        $datos->culturale()->associate($ch_plan);
        $datos->culturale()->associate($ch_acum);
        $datos->culturale()->associate($ch_diario);
        $datos->culturale()->associate($d_d);
        $datos->culturale()->associate($cc);
        $datos->culturale()->associate($tipo_peloton);

        $datos->save();
        
        return response()->json(['incidencia_culturale' => new IncidenciaCulturaleResource($datos)], 200);
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
        $c_plan = IncidenciaCulturale::where('c_plan', $request->culturale)->first();
        $c_acum = IncidenciaCulturale::where('c_acum', $request->culturale)->first();
        $c_diario = IncidenciaCulturale::where('c_diario', $request->culturale)->first();
        $p_plan = IncidenciaCulturale::where('p_plan', $request->culturale)->first();
        $p_acum = IncidenciaCulturale::where('p_acum', $request->culturale)->first();
        $p_diario = IncidenciaCulturale::where('p_diario', $request->culturale)->first();
        $l_plan = IncidenciaCulturale::where('l_plan', $request->culturale)->first();
        $l_acum = IncidenciaCulturale::where('l_acum', $request->culturale)->first();
        $l_diario = IncidenciaCulturale::where('l_diario', $request->culturale)->first();
        $ch_plan = IncidenciaCulturale::where('ch_plan', $request->culturale)->first();
        $ch_acum = IncidenciaCulturale::where('ch_acum', $request->culturale)->first();
        $ch_diario = IncidenciaCulturale::where('ch_diario', $request->culturale)->first();
        $d_d = IncidenciaCulturale::where('d_d', $request->culturale)->first();
        $cc = IncidenciaCulturale::where('cc', $request->culturale)->first();
        $tipo_peloton = IncidenciaCulturale::where('tipo_peloton', $request->culturale)->first();

        $datos = IncidenciaCulturale::find($id);

        $datos->cultivo()->dissociate($cultivo);
        $datos->cultivo()->associate($cultivo);
        $datos->cultivo()->dissociate($ueb);
        $datos->cultivo()->associate($ueb);
        $datos->culturale()->associate($c_plan);
        $datos->culturale()->dissociate($c_plan);
        $datos->culturale()->associate($c_acum);
        $datos->culturale()->dissociate($c_acum);
        $datos->culturale()->associate($c_diario);
        $datos->culturale()->dissociate($c_diario);

        $datos->culturale()->associate($p_plan);
        $datos->culturale()->dissociate($p_plan);
        $datos->culturale()->associate($p_acum);
        $datos->culturale()->dissociate($p_acum);
        $datos->culturale()->associate($p_diario);
        $datos->culturale()->dissociate($p_diario);
        
        $datos->culturale()->associate($l_plan);
        $datos->culturale()->dissociate($l_plan);
        $datos->culturale()->associate($l_acum);
        $datos->culturale()->dissociate($l_acum);
        $datos->culturale()->associate($l_diario);
        $datos->culturale()->dissociate($l_diario);

        $datos->culturale()->associate($ch_plan);
        $datos->culturale()->dissociate($ch_plan);
        $datos->culturale()->associate($ch_acum);
        $datos->culturale()->dissociate($ch_acum);
        $datos->culturale()->associate($ch_diario);
        $datos->culturale()->dissociate($ch_diario);

        $datos->culturale()->associate($cc);
        $datos->culturale()->dissociate($cc);
        $datos->culturale()->associate($d_d);
        $datos->culturale()->dissociate($d_d);
        $datos->culturale()->associate($tipo_peloton);
        $datos->culturale()->dissociate($tipo_peloton);

        $datos->c_plan = $request->c_plan;
        $datos->c_acum = $request->c_acum;
        $datos->c_diario = $request->c_diario;
        $datos->p_plan = $request->p_plan;
        $datos->p_acum = $request->p_acum;
        $datos->p_diario = $request->p_diario;
        $datos->l_plan = $request->l_plan;
        $datos->l_acum = $request->l_acum;
        $datos->l_diario = $request->l_diario;
        $datos->ch_plan = $request->ch_plan;
        $datos->ch_acum = $request->ch_acum;
        $datos->ch_diario = $request->ch_diario;
        $datos->cc = $request->cc;
        $datos->d_d = $request->d_d;
        $datos->tipo_peloton = $request->tipo_peloton;

        $datos->save();
        return response()->json(['incidencia_culturale' => new IncidenciaCulturaleResource($datos)], 200);
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
