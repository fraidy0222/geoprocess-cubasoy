<?php

namespace App\Http\Controllers\Api;

use App\Ausencia;
use App\Cultivo;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncideniciaAusenciasResource;
use App\IncidenciaAusencia;
use App\Ueb;
use Illuminate\Http\Request;

class IncidenciaAusenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'ausencias' => IncideniciaAusenciasResource::collection(IncidenciaAusencia::all()),
            'ueb' => Ueb::pluck('name')->all(),
            'cultivo' => Cultivo::pluck('name')->all(),
            'certificados_medicos' => Ausencia::pluck('certificados_medicos')->all(),
            'lic_maternidad' => Ausencia::pluck('lic_maternidad')->all(),
            'vacaciones' => Ausencia::pluck('vacaciones')->all(),
            'aus_autorizadas' => Ausencia::pluck('aus_autorizadas')->all(),
            'aus_injustificadas' => Ausencia::pluck('aus_injustificadas')->all(),
            'otras' => Ausencia::pluck('otras')->all(),
            'aislados' => Ausencia::pluck('aislados')->all(),
            'positivos' => Ausencia::pluck('positivos')->all(),
            'madres_ninnos' => Ausencia::pluck('madres_ninnos')->all(),
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
        $certificados_medicos = IncidenciaAusencia::where('certificados_medicos', $request->ausencia)->first();
        $lic_maternidad = IncidenciaAusencia::where('lic_maternidad', $request->ausencia)->first();
        $vacaciones = IncidenciaAusencia::where('vacaciones', $request->ausencia)->first();
        $aus_autorizadas = IncidenciaAusencia::where('aus_autorizadas', $request->ausencia)->first();
        $aus_injustificadas = IncidenciaAusencia::where('aus_injustificadas', $request->ausencia)->first();
        $otras = IncidenciaAusencia::where('otras', $request->ausencia)->first();
        $aislados = IncidenciaAusencia::where('aislados', $request->ausencia)->first();
        $positivos = IncidenciaAusencia::where('positivos', $request->ausencia)->first();
        $madres_ninnos = IncidenciaAusencia::where('madres_ninnos', $request->ausencia)->first();

        $datos = IncidenciaAusencia::create([
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

        $datos->ueb()->associate($ueb);
        $datos->ausencia()->associate($certificados_medicos);
        $datos->ausencia()->associate($lic_maternidad);
        $datos->ausencia()->associate($vacaciones);
        $datos->ausencia()->associate($aus_autorizadas);
        $datos->ausencia()->associate($aus_injustificadas);
        $datos->ausencia()->associate($otras);
        $datos->ausencia()->associate($aislados);
        $datos->ausencia()->associate($positivos);
        $datos->ausencia()->associate($madres_ninnos);

        $datos->save();
        
        return response()->json(['incidencia_ausencia' => new IncideniciaAusenciasResource($datos)], 200);
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
        $certificados_medicos = IncidenciaAusencia::where('certificados_medicos', $request->ausencia)->first();
        $lic_maternidad = IncidenciaAusencia::where('lic_maternidad', $request->ausencia)->first();
        $vacaciones = IncidenciaAusencia::where('vacaciones', $request->ausencia)->first();
        $aus_autorizadas = IncidenciaAusencia::where('aus_autorizadas', $request->ausencia)->first();
        $aus_injustificadas = IncidenciaAusencia::where('aus_injustificadas', $request->ausencia)->first();
        $otras = IncidenciaAusencia::where('otras', $request->ausencia)->first();
        $aislados = IncidenciaAusencia::where('aislados', $request->ausencia)->first();
        $positivos = IncidenciaAusencia::where('positivos', $request->ausencia)->first();
        $madres_ninnos = IncidenciaAusencia::where('madres_ninnos', $request->ausencia)->first();
        
        $datos = IncidenciaAusencia::find($id);
        $datos->ueb()->dissociate($ueb);
        $datos->ueb()->associate($ueb);
        $datos->ausencia()->dissociate($certificados_medicos);
        $datos->ausencia()->associate($certificados_medicos);
        $datos->ausencia()->dissociate($lic_maternidad);
        $datos->ausencia()->associate($lic_maternidad);
        $datos->ausencia()->dissociate($vacaciones);
        $datos->ausencia()->associate($vacaciones);
        $datos->ausencia()->dissociate($aus_autorizadas);
        $datos->ausencia()->associate($aus_autorizadas);
        $datos->ausencia()->dissociate($aus_injustificadas);
        $datos->ausencia()->associate($aus_injustificadas);
        $datos->ausencia()->dissociate($otras);
        $datos->ausencia()->associate($otras);
        $datos->ausencia()->dissociate($aislados);
        $datos->ausencia()->associate($aislados);
        $datos->ausencia()->dissociate($positivos);
        $datos->ausencia()->associate($positivos);
        $datos->ausencia()->dissociate($madres_ninnos);
        $datos->ausencia()->associate($madres_ninnos);

        $datos->certificados_medicos = $request->certificados_medicos;
        $datos->lic_maternidad = $request->lic_maternidad;
        $datos->vacaciones = $request->vacaciones;
        $datos->aus_autorizadas = $request->aus_autorizadas;
        $datos->aus_injustificadas = $request->aus_injustificadas;
        $datos->otras = $request->otras;
        $datos->aislados = $request->aislados;
        $datos->positivos = $request->positivos;
        $datos->madres_ninnos = $request->madres_ninnos;

        $datos->save();
        return response()->json(['incidencia_quimico' => new IncideniciaAusenciasResource($datos)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *positivos
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
