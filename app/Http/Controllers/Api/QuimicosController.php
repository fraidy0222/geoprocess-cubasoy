<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuimicosResource;
use App\Quimico;
use App\Ueb;
use DateTime;
use Illuminate\Http\Request;

class QuimicosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return response()->json(['quimicos' => QuimicosResource::collection(Quimico::all()), 'uebs' => Ueb::pluck('name')->all()], 200);
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
        $quimicos = Quimico::create([
          'cc' => $request->cc,
          'tipo_aplicacion' => $request->tipo_aplicacion,
          'tipo_producto' => $request->tipo_producto,
          'area_aplicada' => $request->area_aplicada,
          'area_acum' => $request->area_acum,
          'cant' => $request->cant,
          'cant_equipos' => $request->cant_equipos,
          'comienza' => $request->comienza,
          'termina' => $request->termina,
        ]);
        $quimicos->ueb()->associate($ueb);
  
        $quimicos->save();
  
        return response()->json(['quimicos' => new QuimicosResource($quimicos)], 200);
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
        $quimicos = Quimico::find($id);
        $quimicos->ueb()->dissociate($ueb);
        $quimicos->ueb()->associate($ueb);
        $quimicos->cc = $request->cc;
        $quimicos->tipo_aplicacion = $request->tipo_aplicacion;
        $quimicos->tipo_producto = $request->tipo_producto;
        $quimicos->area_aplicada = $request->area_aplicada;
        $quimicos->area_acum = $request->area_acum;
        $quimicos->cant = $request->cant;
        $quimicos->cant_equipos = $request->cant_equipos;
        $quimicos->comienza = $request->comienza;
        $quimicos->termina = $request->termina;
    
        $quimicos->save();
      
        return response()->json(['quimicos' => new QuimicosResource($quimicos)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quimicos = Quimico::find($id)->delete();

        return response()->json(['quimicos' => $quimicos], 200);
    }
}
