<?php

namespace App\Http\Controllers\Api;

use App\Cultivo;
use App\Diario;
use App\Http\Controllers\Controller;
use App\Http\Resources\DiarioResource;
use Illuminate\Http\Request;

class DiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'diario' => DiarioResource::collection(Diario::all()),
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
        $cultivo = Cultivo::where('name', $request->cultivo)->first();
        $diario = Diario::create([
            't_diario' => $request->t_diario,
            't_plan' => $request->t_plan,
            't_real' => $request->t_real,
            'porciento' => $request->porciento,
        ]);

        $diario->cultivo()->associate($cultivo);

        $diario->save();

        return response()->json(['diario' => new DiarioResource(($diario))], 200);
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
        $diario = Diario::find($id);
        $diario->cultivo()->dissociate($cultivo);
        $diario->cultivo()->associate($cultivo);
        $diario->t_diario = $request->t_diario;
        $diario->t_plan = $request->t_plan;
        $diario->t_real = $request->t_real;
        $diario->porciento = $request->porciento;

        $diario->save();

        return response()->json(['diario' => new DiarioResource(($diario))], 200);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $diario = Diario::find($id)->delete();

        return response()->json(['diario' => $diario]);
    }
}
