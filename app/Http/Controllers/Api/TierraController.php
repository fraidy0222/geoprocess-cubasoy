<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TierraResource;
use App\Tierra;
use App\Ueb;
use Illuminate\Http\Request;

class TierraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'tierra' => TierraResource::collection(Tierra::all()),
            'uebs' => Ueb::pluck('name')->all(),
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
        $tierra = Tierra::create([
          'cc' => $request->cc,
          'tipo_peloton' => $request->tipo_peloton,
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
          'nivelacio_rail' => $request->nivelacio_rail,
        ]);
        $tierra->ueb()->associate($ueb);
  
        $tierra->save();
  
        return response()->json(['tierra' => new TierraResource($tierra)], 200);
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
      
        $tierra = Tierra::find($id);
        $tierra->ueb()->dissociate($ueb);
        $tierra->ueb()->associate($ueb);
        $tierra->cc = $request->cc;
        $tierra->tipo_peloton = $request->tipo_peloton;
        $tierra->r_plan = $request->r_plan;
        $tierra->r_acum = $request->r_acum;
        $tierra->r_diario = $request->r_diario;
        $tierra->g_plan = $request->g_plan;
        $tierra->g_acum = $request->g_acum;
        $tierra->g_diario = $request->g_diario;
        $tierra->c_plan = $request->c_plan;
        $tierra->c_acum = $request->c_acum;
        $tierra->c_diario = $request->c_diario;
        $tierra->s_plan = $request->s_plan;
        $tierra->s_acum = $request->s_acum;
        $tierra->s_diario = $request->s_diario;
        $tierra->nivelacio_rail = $request->nivelacio_rail;
        
        $tierra->save();
        
        return response()->json(['tierra' => new TierraResource($tierra)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tierra = Tierra::find($id)->delete();

        return response()->json(['tierra' => $tierra], 200);
    }   
}
