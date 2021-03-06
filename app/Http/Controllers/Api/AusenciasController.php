<?php

namespace App\Http\Controllers\Api;

use App\Ausencia;
use App\Http\Controllers\Controller;
use App\Http\Resources\AusenciasResource;
use App\Ueb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AusenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $count = DB::table('ausencias')
      ->select( DB::raw('
      sum(certificados_medicos) as certificados, 
      sum(otras) as otros, 
      sum(lic_maternidad) as maternidad, 
      sum(vacaciones) as vacaciones,
      sum(aus_autorizadas) as auto,
      sum(aus_injustificadas) as inju,
      sum(aislados) as aislados,
      sum(positivos) as posi,
      sum(madres_ninnos) as madre
      '),  
      DB::raw(
        'SUM(certificados_medicos + 
        otras + 
        lic_maternidad + 
        vacaciones + 
        aus_autorizadas + 
        aus_injustificadas +
        aislados +
        positivos +
        madres_ninnos
        ) 
      as total'))  
      ->get();
    
      $total = DB::table('ausencias')
      ->select(
        DB::raw(
          'SUM(certificados_medicos + 
          otras + 
          lic_maternidad + 
          vacaciones + 
          aus_autorizadas + 
          aus_injustificadas +
          aislados +
          positivos +
          madres_ninnos
          ) 
        as total'))
      ->groupBy('id')
      ->get();

      return response()->json([
        'ausencias' => AusenciasResource::collection(Ausencia::all()), 
        'uebs' => Ueb::pluck('name')->all(),
        'count' => $count,
        'total' => $total 
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
