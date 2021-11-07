<?php

namespace App\Http\Controllers\Api;

use App\Cultivo;
use App\Http\Controllers\Controller;
use App\Http\Resources\SiembraResource;
use App\Siembra;
use App\Ueb;
use Illuminate\Http\Request;

class SiembraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'siembra' => SiembraResource::collection(Siembra::all()),
            'uebs' => Ueb::pluck('name')->all(),
            'cultivos' => Cultivo::pluck('name')->all()
        ], 200);
    }

    public function store(Request $request)
    {
        $ueb = Ueb::where('name', $request->ueb)->first();
        $cultivo = Cultivo::where('name', $request->cultivo)->first();
        $siembra = Siembra::create([
          'cc' => $request->cc,
          'area' => $request->area,
          'siembrap' => $request->siembrap,
          'siembraa' => $request->siembraa,
          'siembrad' => $request->siembrad,
          'cantsemillad' => $request->cantsemillad,
          'cantsemillaa' => $request->cantsemillaa,
          'cantsemillaud' => $request->cantsemillaud,
          'cantsemillaua' => $request->cantsemillaua,
        ]);
        $siembra->ueb()->associate($ueb);
        $siembra->cultivo()->associate($cultivo);
  
        $siembra->save();
  
        return response()->json(['siembra' => new SiembraResource($siembra)], 200);
    }

    public function update(Request $request, $id)
    {
        $ueb = Ueb::where('name', $request->ueb)->first();
        $cultivo = Cultivo::where('name', $request->cultivo)->first();
      
      $siembra = Siembra::find($id);
      $siembra->ueb()->dissociate($ueb);
      $siembra->ueb()->associate($ueb);
      $siembra->cultivo()->dissociate($cultivo);
      $siembra->cultivo()->associate($cultivo);
      $siembra->cc = $request->cc;
      $siembra->area = $request->area;
      $siembra->siembrap = $request->siembrap;
      $siembra->siembraa = $request->siembraa;
      $siembra->siembrad = $request->siembrad;
      $siembra->cantsemillad = $request->cantsemillad;
      $siembra->cantsemillaa = $request->cantsemillaa;
      $siembra->cantsemillaud = $request->cantsemillaud;
      $siembra->cantsemillaua = $request->cantsemillaua;
     
      $siembra->save();
    
      return response()->json(['siembra' => new SiembraResource($siembra)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siembra = Siembra::find($id)->delete();

        return response()->json(['siembra' => $siembra], 200);
    }
}
