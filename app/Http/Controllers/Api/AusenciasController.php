<?php

namespace App\Http\Controllers\Api;

use App\Ausencia;
use App\Http\Controllers\Controller;
use App\Http\Resources\AusenciasResource;
use App\Ueb;
use Illuminate\Http\Request;

class AusenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return response()->json(['ausencias' => AusenciasResource::collection(Ausencia::all()), 'uebs' => Ueb::pluck('name')->all()], 200);
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
        $ausencias = Ausencia::create([
          'certificados_medicos' => $request->certificados_medicos,
          'lic_maternidad' => $request->lic_maternidad,
          'vacaciones' => $request->vacaciones,
          'aus_autorizadas' => $request->aus_autorizadas,
          'aus_injustificadas' => $request->aus_injustificadas,
          'otras' => $request->otras,
          'aislados' => $request->aislados,
          'positivos' => $request->positivos,
          'madres_ninnos' => $request->madres_ninnos,
        ]);
        $ausencias->ueb()->associate($ueb);
  
        $ausencias->save();
  
        return response()->json(['ausencias' => new AusenciasResource($ausencias)], 200);
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
      
      $ausencia = Ausencia::find($id);
      $ausencia->ueb()->dissociate($ueb);
      $ausencia->ueb()->associate($ueb);
      $ausencia->certificados_medicos = $request->certificados_medicos;
      $ausencia->lic_maternidad = $request->lic_maternidad;
      $ausencia->vacaciones = $request->vacaciones;
      $ausencia->aus_autorizadas = $request->aus_autorizadas;
      $ausencia->aus_injustificadas = $request->aus_injustificadas;
      $ausencia->otras = $request->otras;
      $ausencia->aislados = $request->aislados;
      $ausencia->positivos = $request->positivos;
      $ausencia->madres_ninnos = $request->madres_ninnos;
     
      $ausencia->save();
    
      return response()->json(['ausencias' => new AusenciasResource($ausencia)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $ausencias = Ausencia::find($id)->delete();

      return response()->json(['ausencias' => $ausencias], 200);
    }
}
