<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maquinas extends Model
{
    protected $fillable = [
        'total_maquinas_riego',
        'maquinas_listas',
        'afectaciones',
        'ueb_id',
    ];

    protected $casts = [
        'maquinas_rotas' => 'array'
    ];


    public function ueb ()
    {
        return $this->belongsTo(Ueb::class);
    }

    public function incidencia_maquina() 
    {
     return $this->hasMany(IncidenciaMaquina::class);
    }
}
