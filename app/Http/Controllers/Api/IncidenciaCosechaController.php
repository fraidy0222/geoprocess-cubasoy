<?php

namespace App\Http\Controllers\Api;

use App\Cosecha;
use App\Cultivo;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncidenciaCosechaResource;
use App\IncidenciaCosecha;
use App\Ueb;
use Illuminate\Http\Request;

class IncidenciaCosechaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'cosecha' => IncidenciaCosechaResource::collection(IncidenciaCosecha::all()),
            'ueb' => Ueb::pluck('name')->all(),
            'cultivo' => Cultivo::pluck('name')->all(),
            'cc' => Cosecha::pluck('cc')->all(),
            'area_total' => Cosecha::pluck('area_total')->all(),
            'a_c_diario' => Cosecha::pluck('a_c_diario')->all(),
            'a_c_acum' => Cosecha::pluck('a_c_acum')->all(),
            'a_c_pendiente' => Cosecha::pluck('a_c_pendiente')->all(),
            't_diario' => Cosecha::pluck('t_diario')->all(),
            't_acum' => Cosecha::pluck('t_acum')->all(),
            't_rend' => Cosecha::pluck('t_rend')->all(),
            'rend_acum' => Cosecha::pluck('rend_acum')->all(),
            'arranque_m' => Cosecha::pluck('arranque_m')->all(),
            'cant_equipos' => Cosecha::pluck('cant_equipos')->all(),
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
        $cc = IncidenciaCosecha::where('cc', $request->cosecha)->first();
        $area_total = IncidenciaCosecha::where('area_total', $request->cosecha)->first();
        $a_c_diario = IncidenciaCosecha::where('a_c_diario', $request->cosecha)->first();
        $a_c_acum = IncidenciaCosecha::where('a_c_acum', $request->cosecha)->first();
        $a_c_pendiente = IncidenciaCosecha::where('a_c_pendiente', $request->cosecha)->first();
        $t_diario = IncidenciaCosecha::where('t_diario', $request->cosecha)->first();
        $t_acum = IncidenciaCosecha::where('t_acum', $request->cosecha)->first();
        $t_rend = IncidenciaCosecha::where('t_rend', $request->cosecha)->first();
        $rend_acum = IncidenciaCosecha::where('rend_acum', $request->cosecha)->first();
        $arranque_m = IncidenciaCosecha::where('arranque_m', $request->cosecha)->first();
        $cant_equipos = IncidenciaCosecha::where('t_rend', $request->cosecha)->first();

        $datos = IncidenciaCosecha::create([
            'cc' => $request->cc,
            'area_total' => $request->area_total,
            'a_c_diario' => $request->a_c_diario,
            'a_c_acum' => $request->a_c_acum,
            'a_c_pendiente' => $request->a_c_pendiente,
            't_diario' => $request->t_diario,
            't_acum' => $request->t_acum,
            't_rend' => $request->t_rend,
            'rend_acum' => $request->rend_acum,
            'arranque_m' => $request->arranque_m,
            'cant_equipos' => $request->cant_equipos,
        ]);

        $datos->ueb()->associate($ueb);
        $datos->cultivo()->associate($cultivo);
        $datos->cosecha()->associate($cc);
        $datos->cosecha()->associate($area_total);
        $datos->cosecha()->associate($a_c_diario);
        $datos->cosecha()->associate($a_c_acum);
        $datos->cosecha()->associate($a_c_pendiente);
        $datos->cosecha()->associate($t_diario);
        $datos->cosecha()->associate($t_acum);
        $datos->cosecha()->associate($t_rend);
        $datos->cosecha()->associate($rend_acum);
        $datos->cosecha()->associate($arranque_m);
        $datos->cosecha()->associate($cant_equipos);

        $datos->save();
        
        return response()->json(['incidencia_cosecha' => new IncidenciaCosechaResource($datos)], 200);
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
        $cc = IncidenciaCosecha::where('cc', $request->cosecha)->first();
        $area_total = IncidenciaCosecha::where('area_total', $request->cosecha)->first();
        $a_c_diario = IncidenciaCosecha::where('a_c_diario', $request->cosecha)->first();
        $a_c_acum = IncidenciaCosecha::where('a_c_acum', $request->cosecha)->first();
        $a_c_pendiente = IncidenciaCosecha::where('a_c_pendiente', $request->cosecha)->first();
        $t_diario = IncidenciaCosecha::where('t_diario', $request->cosecha)->first();
        $t_acum = IncidenciaCosecha::where('t_acum', $request->cosecha)->first();
        $t_rend = IncidenciaCosecha::where('t_rend', $request->cosecha)->first();
        $rend_acum = IncidenciaCosecha::where('rend_acum', $request->cosecha)->first();
        $arranque_m = IncidenciaCosecha::where('arranque_m', $request->cosecha)->first();
        $cant_equipos = IncidenciaCosecha::where('cant_equipos', $request->cosecha)->first();

        $datos = IncidenciaCosecha::find($id);

        $datos->ueb()->dissociate($ueb);
        $datos->ueb()->associate($ueb);
        $datos->cultivo()->dissociate($cultivo);
        $datos->cultivo()->associate($cultivo);
        $datos->cosecha()->dissociate($cc);
        $datos->cosecha()->associate($cc);
        $datos->cosecha()->dissociate($area_total);
        $datos->cosecha()->associate($area_total);
        $datos->cosecha()->dissociate($a_c_diario);
        $datos->cosecha()->associate($a_c_diario);
        $datos->cosecha()->dissociate($a_c_acum);
        $datos->cosecha()->associate($a_c_acum);
        $datos->cosecha()->dissociate($a_c_pendiente);
        $datos->cosecha()->associate($a_c_pendiente);
        $datos->cosecha()->dissociate($t_diario);
        $datos->cosecha()->associate($t_diario);
        $datos->cosecha()->dissociate($t_acum);
        $datos->cosecha()->associate($t_acum);
        $datos->cosecha()->dissociate($t_rend);
        $datos->cosecha()->associate($t_rend);
        $datos->cosecha()->dissociate($rend_acum);
        $datos->cosecha()->associate($rend_acum);
        $datos->cosecha()->dissociate($arranque_m);
        $datos->cosecha()->associate($arranque_m);
        $datos->cosecha()->dissociate($cant_equipos);
        $datos->cosecha()->associate($cant_equipos);

        $datos->cc = $request->cc;
        $datos->area_total = $request->area_total;
        $datos->a_c_diario = $request->a_c_diario;
        $datos->a_c_acum = $request->a_c_acum;
        $datos->a_c_pendiente = $request->a_c_pendiente;
        $datos->t_diario = $request->t_diario;
        $datos->t_acum = $request->t_acum;
        $datos->t_rend = $request->t_rend;
        $datos->rend_acum = $request->rend_acum;
        $datos->arranque_m = $request->arranque_m;
        $datos->cant_equipos = $request->cant_equipos;

        $datos->save();

        return response()->json(['incidencia_cosecha' => new IncidenciaCosechaResource($datos)], 200);
        
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
