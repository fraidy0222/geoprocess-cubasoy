<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Ueb;
use Illuminate\Http\Request;

class UebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        // // sumar un elemento de la base de datos 

        // $total = DB::table('uebs')
        // ->select(DB::raw('sum(total_maquinas_riego) as total'))
        // ->get();

        // $listas = DB::table('uebs')
        // ->select(DB::raw('sum(maquinas_listas) as listas'))
        // ->get();

        return response()->json(['ueb' => Ueb::all()], 200);
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ueb = Ueb::create([
            'name' => $request->name
        ]);
        
        $ueb->save();

        return response()->json(['ueb' => $ueb ], 200);
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
        $ueb = Ueb::find($id);
        $ueb->name = request('name');
       
        $ueb->save();

        return response()->json(['ueb' => $ueb], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ueb = Ueb::find($id)->delete();

        return response()->json(['ueb' => $ueb], 200);
    }
}
