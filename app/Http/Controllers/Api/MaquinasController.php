<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MaquinasResource;
use App\Maquinas;
use App\Ueb;
use Illuminate\Http\Request;

class MaquinasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // // sumar un elemento de la base de datos 
        // $total = DB::table('maquinas')
        // ->select(DB::raw('sum(total_maquinas_riego) as total'))
        // ->get();

        // $listas = DB::table('maquinas')
        // ->select(DB::raw('sum(maquinas_listas) as listas'))
        // ->get();
        return response()->json(['maquina' => MaquinasResource::collection(Maquinas::all()), 'uebs' => Ueb::pluck('name')->all() ], 200);
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

        $maquina =  new Maquinas();
            $maquina->total_maquinas_riego = request('total_maquinas_riego');
            $maquina->maquinas_listas = request('maquinas_listas');
            $maquina->afectaciones = request('afectaciones');
            $maquina->maquinas_rotas = request('maquinas_rotas');
        $maquina->ueb()->associate($ueb);

        $maquina->save();

        return response()->json(['maquina' => new MaquinasResource($maquina) ], 200);
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

        $maquina = Maquinas::find($id);
        $maquina->ueb()->dissociate($ueb);
        $maquina->ueb()->associate($ueb);
        $maquina->total_maquinas_riego = request('total_maquinas_riego');
        $maquina->maquinas_listas = request('maquinas_listas');
        $maquina->afectaciones = request('afectaciones');
        $maquina->maquinas_rotas = request('maquinas_rotas');

        $maquina->save();

        return response()->json(['maquina' => new MaquinasResource($maquina)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $maquina = Maquinas::find($id)->delete();

        return response()->json(['maquina' => $maquina], 200);
    }
}
