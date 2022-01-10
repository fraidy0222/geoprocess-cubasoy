<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IncidenciaTierraResource;
use App\IncidenciaTierra;
use App\Tierra;
use App\Ueb;
use Illuminate\Http\Request;

class IncidenciaTierraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'tierra' => IncidenciaTierraResource::collection(IncidenciaTierra::all()),
            'ueb' => Ueb::pluck('name')->all(),
            'cc' => Tierra::pluck('cc')->all(),
            'tipo_peloton' => Tierra::pluck('tipo_peloton')->all(),
            'nivelacio_rail' => Tierra::pluck('nivelacio_rail')->all(),
            'r_plan' => Tierra::pluck('r_plan')->all(),
            'r_acum' => Tierra::pluck('r_acum')->all(),
            'r_diario' => Tierra::pluck('r_diario')->all(),
            'g_plan' => Tierra::pluck('g_plan')->all(),
            'g_acum' => Tierra::pluck('g_acum')->all(),
            'g_diario' => Tierra::pluck('g_diario')->all(),
            'c_plan' => Tierra::pluck('c_plan')->all(),
            'c_acum' => Tierra::pluck('c_acum')->all(),
            'c_diario' => Tierra::pluck('c_diario')->all(),
            's_plan' => Tierra::pluck('s_plan')->all(),
            's_acum' => Tierra::pluck('s_acum')->all(),
            's_diario' => Tierra::pluck('s_diario')->all(),
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
        $cc = IncidenciaTierra::where('cc', $request->tierra)->first();
        $tipo_peloton = IncidenciaTierra::where('tipo_peloton', $request->tierra)->first();
        $nivelacio_rail = IncidenciaTierra::where('nivelacio_rail', $request->tierra)->first();
        $r_plan = IncidenciaTierra::where('r_plan', $request->tierra)->first();
        $r_acum = IncidenciaTierra::where('r_acum', $request->tierra)->first();
        $r_diario = IncidenciaTierra::where('r_diario', $request->tierra)->first();
        $g_plan = IncidenciaTierra::where('g_plan', $request->tierra)->first();
        $g_acum = IncidenciaTierra::where('g_acum', $request->tierra)->first();
        $g_diario = IncidenciaTierra::where('g_diario', $request->tierra)->first();
        $c_plan = IncidenciaTierra::where('c_plan', $request->tierra)->first();
        $c_acum = IncidenciaTierra::where('c_acum', $request->tierra)->first();
        $c_diario = IncidenciaTierra::where('c_diario', $request->tierra)->first();
        $s_plan = IncidenciaTierra::where('s_plan', $request->tierra)->first();
        $s_acum = IncidenciaTierra::where('s_acum', $request->tierra)->first();
        $s_diario = IncidenciaTierra::where('s_diario', $request->tierra)->first();
        
        $datos = IncidenciaTierra::create([
            'cc' => $request->cc,
            'tipo_peloton' => $request->tipo_peloton,
            'nivelacio_rail' => $request->nivelacio_rail,
            'r_plan' => $request->r_plan,
            'r_acum' => $request->r_acum,
            'r_diario' => $request->r_diario,
            'g_plan' => $request->g_plan,
            'g_acum' => $request->g_acum,
            'g_diario' => $request->g_diario,
            'c_plan' => $request->c_plan,
            'c_acum' => $request->c_acum,
            'c_diario' => $request->c_diario,
            's_plan' => $request->s_plan,
            's_acum' => $request->s_acum,
            's_diario' => $request->s_diario,
        ]);

        $datos->ueb()->associate($ueb);
        $datos->tierra()->associate($cc);
        $datos->tierra()->associate($tipo_peloton);
        $datos->tierra()->associate($nivelacio_rail);
        $datos->tierra()->associate($r_plan);
        $datos->tierra()->associate($r_acum);
        $datos->tierra()->associate($r_diario);
        $datos->tierra()->associate($g_plan);
        $datos->tierra()->associate($g_acum);
        $datos->tierra()->associate($g_diario);
        $datos->tierra()->associate($c_plan);
        $datos->tierra()->associate($c_acum);
        $datos->tierra()->associate($c_diario);
        $datos->tierra()->associate($s_plan);
        $datos->tierra()->associate($s_acum);
        $datos->tierra()->associate($s_diario);

        $datos->save();
        
        return response()->json(['incidencia_tierra' => new IncidenciaTierraResource($datos)], 200);
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
        $cc = IncidenciaTierra::where('cc', $request->tierra)->first();
        $tipo_peloton = IncidenciaTierra::where('tipo_peloton', $request->tierra)->first();
        $nivelacio_rail = IncidenciaTierra::where('nivelacio_rail', $request->tierra)->first();
        $r_plan = IncidenciaTierra::where('r_plan', $request->tierra)->first();
        $r_acum = IncidenciaTierra::where('r_acum', $request->tierra)->first();
        $r_diario = IncidenciaTierra::where('r_diario', $request->tierra)->first();
        $g_plan = IncidenciaTierra::where('g_plan', $request->tierra)->first();
        $g_acum = IncidenciaTierra::where('g_acum', $request->tierra)->first();
        $g_diario = IncidenciaTierra::where('g_diario', $request->tierra)->first();
        $c_plan = IncidenciaTierra::where('c_plan', $request->tierra)->first();
        $c_acum = IncidenciaTierra::where('c_acum', $request->tierra)->first();
        $c_diario = IncidenciaTierra::where('c_diario', $request->tierra)->first();
        $s_plan = IncidenciaTierra::where('s_plan', $request->tierra)->first();
        $s_acum = IncidenciaTierra::where('s_acum', $request->tierra)->first();
        $s_diario = IncidenciaTierra::where('s_diario', $request->tierra)->first();

        $datos = IncidenciaTierra::find($id);

        $datos->ueb()->dissociate($ueb);
        $datos->ueb()->associate($ueb);
        $datos->tierra()->associate($cc);
        $datos->tierra()->dissociate($cc);
        $datos->tierra()->associate($tipo_peloton);
        $datos->tierra()->dissociate($tipo_peloton);
        $datos->tierra()->associate($nivelacio_rail);
        $datos->tierra()->dissociate($nivelacio_rail);
        $datos->tierra()->associate($r_plan);
        $datos->tierra()->dissociate($r_plan);
        $datos->tierra()->associate($r_acum);
        $datos->tierra()->dissociate($r_acum);
        $datos->tierra()->associate($r_diario);
        $datos->tierra()->dissociate($r_diario);
        $datos->tierra()->associate($g_plan);
        $datos->tierra()->dissociate($g_plan);
        $datos->tierra()->associate($g_acum);
        $datos->tierra()->dissociate($g_acum);
        $datos->tierra()->associate($g_diario);
        $datos->tierra()->dissociate($g_diario);
        $datos->tierra()->associate($c_plan);
        $datos->tierra()->dissociate($c_plan);
        $datos->tierra()->associate($c_acum);
        $datos->tierra()->dissociate($c_acum);
        $datos->tierra()->associate($c_diario);
        $datos->tierra()->dissociate($c_diario);
        $datos->tierra()->associate($s_plan);
        $datos->tierra()->dissociate($s_plan);
        $datos->tierra()->associate($s_acum);
        $datos->tierra()->dissociate($s_acum);
        $datos->tierra()->associate($s_diario);
        $datos->tierra()->dissociate($s_diario);

        $datos->cc = $request->cc;
        $datos->tipo_peloton = $request->tipo_peloton;
        $datos->nivelacio_rail = $request->nivelacio_rail;
        $datos->r_plan = $request->r_plan;
        $datos->r_acum = $request->r_acum;
        $datos->r_diario = $request->r_diario;
        $datos->g_plan = $request->g_plan;
        $datos->g_acum = $request->g_acum;
        $datos->g_diario = $request->g_diario;
        $datos->c_plan = $request->c_plan;
        $datos->c_acum = $request->c_acum;
        $datos->c_diario = $request->c_diario;
        $datos->s_plan = $request->s_plan;
        $datos->s_acum = $request->s_acum;
        $datos->s_diario = $request->s_diario;

        $datos->save();
        return response()->json(['incidencia_tierra' => new IncidenciaTierraResource($datos)], 200);
       
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
