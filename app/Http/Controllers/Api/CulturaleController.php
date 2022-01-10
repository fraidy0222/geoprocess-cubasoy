<?php

namespace App\Http\Controllers\Api;

use App\Cultivo;
use App\Culturale;
use App\Http\Controllers\Controller;
use App\Http\Resources\CulturaleResource;
use App\Ueb;
use Illuminate\Http\Request;

class CulturaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return response()->json([
        'culturales' => CulturaleResource::collection(Culturale::all()), 
        'uebs' => Ueb::pluck('name')->all(),
        'cultivos' => Cultivo::pluck('name')->all(),
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
        $culturales = Culturale::create([
          'cc' => $request->cc,
          'tipo_peloton' => $request->tipo_peloton,
          'c_plan' => $request->c_plan,
          'c_acum' => $request->c_acum,
          'c_diario' => $request->c_diario,
          'p_plan' => $request->p_plan,
          'p_acum' => $request->p_acum,
          'p_diario' => $request->p_diario,
          'l_plan' => $request->l_plan,
          'l_acum' => $request->l_acum,
          'l_diario' => $request->l_diario,
          'ch_plan' => $request->ch_plan,
          'ch_acum' => $request->ch_acum,
          'ch_diario' => $request->ch_diario,
          'd_d' => $request->d_d,
        ]);
        $culturales->ueb()->associate($ueb);
        $culturales->cultivo()->associate($cultivo);
  
        $culturales->save();
  
        return response()->json(['culturales' => new CulturaleResource($culturales)], 200);
    }

    public function update(Request $request, $id)
    {
      $ueb = Ueb::where('name', $request->ueb)->first();
      $cultivo = Cultivo::where('name', $request->cultivo)->first();
      
      $culturales = Culturale::find($id);
      $culturales->ueb()->dissociate($ueb);
      $culturales->ueb()->associate($ueb);
      $culturales->cultivo()->dissociate($cultivo);
      $culturales->cultivo()->associate($cultivo);
      $culturales->cc = $request->cc;
      $culturales->tipo_peloton = $request->tipo_peloton;
      $culturales->c_plan = $request->c_plan;
      $culturales->c_acum = $request->c_acum;
      $culturales->c_diario = $request->c_diario;
      $culturales->p_plan = $request->p_plan;
      $culturales->p_acum = $request->p_acum;
      $culturales->p_diario = $request->p_diario;
      $culturales->l_plan = $request->l_plan;
      $culturales->l_acum = $request->l_acum;
      $culturales->l_diario = $request->l_diario;
      $culturales->ch_plan = $request->ch_plan;
      $culturales->ch_acum = $request->ch_acum;
      $culturales->ch_diario = $request->ch_diario;
      $culturales->d_d = $request->d_d;
 
      $culturales->save();
    
      return response()->json(['culturales' => new CulturaleResource($culturales)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $culturales = Culturale::find($id)->delete();

      return response()->json(['culturales' => $culturales], 200);
    }
}
