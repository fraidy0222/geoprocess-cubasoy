<?php

namespace App\Http\Controllers\Api;

use App\Cultivo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CultivosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['cultivo' => Cultivo::all()], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cultivo = Cultivo::create([
            'name' => $request->name,
        ]);

        return response()->json(['cultivo' => $cultivo], 200);
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
        $cultivo = Cultivo::find($id);
        $cultivo->name = $request->name;

        $cultivo->save();
    
        return response()->json(['cultivo' => $cultivo], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cultivo = Cultivo::find($id)->delete();

        return response()->json(['cultivo' => $cultivo], 200);
    }
}
