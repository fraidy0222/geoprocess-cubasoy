<?php

namespace App\Http\Controllers\Api;

use App\Energia;
use App\Http\Controllers\Controller;
use App\Http\Resources\EnergiaResource;
use App\Ueb;
use Illuminate\Http\Request;

class EnergiaController extends Controller
{
  
  public function index()
  {
    return response()->json(['energias' => EnergiaResource::collection(Energia::all()), 'uebs' => Ueb::pluck('name')->all()], 200);
  }

  public function store(Request $request)
  {
    $ueb = Ueb::where('name', $request->ueb)->first();
    $energias = Energia::create([
      'plan_mes_energia' => $request->plan_mes_energia,
      'plan_real_energia' => $request->plan_real_energia,
      'porciento_energia' => $request->porciento_energia,
      'plan_mes_petroleo' => $request->plan_mes_petroleo,
      'plan_real_petroleo' => $request->plan_real_petroleo,
      'porciento_petroleo' => $request->porciento_petroleo,
    ]);

    $energias->ueb()->associate($ueb);

    $energias->save();

    return response()->json(['energias' => new EnergiaResource($energias)], 200);
  }

  
  public function update(Request $request, $id)
  {
    $ueb = Ueb::where('name', $request->ueb)->first();
    $energias = Energia::find($id);
    $energias->ueb()->dissociate($ueb);
    $energias->ueb()->associate($ueb);
    $energias->plan_mes_energia = $request->plan_mes_energia;
    $energias->plan_real_energia = $request->plan_real_energia;
    $energias->porciento_energia = $request->porciento_energia;
    $energias->plan_mes_petroleo = $request->plan_mes_petroleo;
    $energias->plan_real_petroleo = $request->plan_real_petroleo;
    $energias->porciento_petroleo = $request->porciento_petroleo;

    $energias->save();

    return response()->json(['energias' => new EnergiaResource($energias)], 200);
  }

  
  public function destroy($id)
  {
    $energias = Energia::find($id)->delete();

    return response()->json(['enerigas' => $energias], 200);
  }
}
