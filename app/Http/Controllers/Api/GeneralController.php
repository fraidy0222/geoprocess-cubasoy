<?php

namespace App\Http\Controllers\Api;

use App\Cultivo;
use App\General;
use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralResource;
use App\Ueb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tonelada = DB::table('toneladas')
        ->select(DB::raw('sum(acum_mes) as mes'))
        ->get();

        $valores = DB::table('valores')
        ->select(DB::raw('sum(venta_mes_cup) as venta'))
        ->get();

        $quimicos = DB::table('quimicos')
        ->select(DB::raw('sum(area_aplicada) as aplicada, count(cc) as c'))
        ->get();

        // $cosecha = DB::table('cosechas')
        //     ->select('cosechas.t_diario', 'cosechas.a_c_diario', 'cosechas.arranque_m', 'cosechas.cc')
        //     ->orderBy('id', 'desc')
        //     ->limit('1')
        //     ->get();
        $cosecha = DB::table('cultivos as cu')
            ->join('cosechas as c', 'cu.id', '=', 'c.cultivo_id')
            ->select('cu.*', 'c.cc', 'c.t_diario', 'c.a_c_diario',  'c.arranque_m', 'c.created_at')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get();
    
        $culurale = DB::table('culturales')
        ->select(DB::raw('sum(culturales.l_acum) as acum'))
        ->get();

        $tierra = DB::table('tierras')
        ->select(DB::raw('sum(g_diario) as grada'))
        ->get();

       return response()->json([
           'general' => GeneralResource::collection(General::all()),
           'uebs' => Ueb::pluck('name')->all(),
           'cultivo' => Cultivo::pluck('name')->all(),
           'tonelada' => $tonelada,
           'valores' => $valores,
           'quimicos' => $quimicos,
           'cosecha' => $cosecha,
           'culturale' => $culurale,
           'tierra' => $tierra
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
