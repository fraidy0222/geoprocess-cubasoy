<?php

namespace App\Http\Controllers\Api;

use App\Cultivo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\IndicendiaSiembraResource;
use App\IncidenciaSiembra;
use App\Siembra;
use App\Ueb;
use Illuminate\Support\Facades\DB;

class IncidenciaSiembraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'siembra' => IndicendiaSiembraResource::collection(IncidenciaSiembra::all()),
            'ueb' => Ueb::pluck('name')->all(),
            'cultivo' => Cultivo::pluck('name')->all(),
            'cc' => Siembra::pluck('cc')->all(),
            'area' => Siembra::pluck('area')->all(),
            'siembrap' => Siembra::pluck('siembrap')->all(),
            'siembraa' => Siembra::pluck('siembraa')->all(),
            'siembrad' => Siembra::pluck('siembrad')->all(),
            'cantsemillad' => Siembra::pluck('cantsemillad')->all(),
            'cantsemillaa' => Siembra::pluck('cantsemillaa')->all(),
            'cantsemillaud' => Siembra::pluck('cantsemillaud')->all(),
            'cantsemillaua' => Siembra::pluck('cantsemillaua')->all(),
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
        $cultivo = Cultivo::where('name', $request->cultivo)->first();
        $cc = IncidenciaSiembra::where('cc', $request->siembra)->first();
        $area = IncidenciaSiembra::where('area', $request->siembra)->first();
        $siembrap = IncidenciaSiembra::where('siembrap', $request->siembra)->first();
        $siembraa = IncidenciaSiembra::where('siembraa', $request->siembra)->first();
        $siembrad = IncidenciaSiembra::where('siembrad', $request->siembra)->first();
        $cantsemillad = IncidenciaSiembra::where('cantsemillad', $request->siembra)->first();
        $cantsemillaa = IncidenciaSiembra::where('cantsemillaa', $request->siembra)->first();
        $cantsemillaud = IncidenciaSiembra::where('cantsemillaud', $request->siembra)->first();
        $cantsemillaua = IncidenciaSiembra::where('cantsemillaua', $request->siembra)->first();

        $datos = IncidenciaSiembra::create([
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

        $datos->ueb()->associate($ueb);
        $datos->cultivo()->associate($cultivo);
        $datos->siembra()->associate($cc);
        $datos->siembra()->associate($area);
        $datos->siembra()->associate($siembrap);
        $datos->siembra()->associate($siembraa);
        $datos->siembra()->associate($siembrad);
        $datos->siembra()->associate($cantsemillad);
        $datos->siembra()->associate($cantsemillaa);
        $datos->siembra()->associate($cantsemillaud);
        $datos->siembra()->associate($cantsemillaua);

        $datos->save();
        
        return response()->json(['incidencia_siembra' => new IndicendiaSiembraResource($datos)], 200);
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
        $cc = IncidenciaSiembra::where('cc', $request->siembra)->first();
        $area = IncidenciaSiembra::where('area', $request->siembra)->first();
        $siembrap = IncidenciaSiembra::where('siembrap', $request->siembra)->first();
        $siembraa = IncidenciaSiembra::where('siembraa', $request->siembra)->first();
        $siembrad = IncidenciaSiembra::where('siembrad', $request->siembra)->first();
        $cantsemillad = IncidenciaSiembra::where('cantsemillad', $request->siembra)->first();
        $cantsemillaa = IncidenciaSiembra::where('cantsemillaa', $request->siembra)->first();
        $cantsemillaud = IncidenciaSiembra::where('cantsemillaud', $request->siembra)->first();
        $cantsemillaua = IncidenciaSiembra::where('cantsemillaua', $request->siembra)->first();
        
        $datos = IncidenciaSiembra::find($id);

        $datos->ueb()->dissociate($ueb);
        $datos->ueb()->associate($ueb);
        $datos->cultivo()->dissociate($cultivo);
        $datos->cultivo()->associate($cultivo);
        $datos->siembra()->associate($cc);
        $datos->siembra()->dissociate($cc);
        $datos->siembra()->associate($area);
        $datos->siembra()->dissociate($area);
        $datos->siembra()->associate($siembrap);
        $datos->siembra()->dissociate($siembrap);
        $datos->siembra()->associate($siembraa);
        $datos->siembra()->dissociate($siembraa);
        $datos->siembra()->associate($siembrad);
        $datos->siembra()->dissociate($siembrad);
        $datos->siembra()->associate($cantsemillad);
        $datos->siembra()->dissociate($cantsemillad);
        $datos->siembra()->associate($cantsemillaa);
        $datos->siembra()->dissociate($cantsemillaa);
        $datos->siembra()->associate($cantsemillaud);
        $datos->siembra()->dissociate($cantsemillaud);
        $datos->siembra()->associate($cantsemillaua);
        $datos->siembra()->dissociate($cantsemillaua);

        $datos->cc = $request->cc;
        $datos->area = $request->area;
        $datos->siembrap = $request->siembrap;
        $datos->siembraa = $request->siembraa;
        $datos->siembrad = $request->siembrad;
        $datos->cantsemillad = $request->cantsemillad;
        $datos->cantsemillaa = $request->cantsemillaa;
        $datos->cantsemillaud = $request->cantsemillaud;
        $datos->cantsemillaua = $request->cantsemillaua;

        $datos->save();
        return response()->json(['incidencia_siembra' => new IndicendiaSiembraResource($datos)], 200);
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
