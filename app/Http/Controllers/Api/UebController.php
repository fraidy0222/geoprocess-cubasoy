<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Siembra;
use App\Ueb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            'name' => $request->name,
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
