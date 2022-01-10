<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidenciaMaquina extends Model
{
    protected $fillable = [
        'ueb_id',
        'maquina_id',
        'total_maquinas_riego',
        'maquinas_listas',
        'afectaciones',
        
    ];

    protected $casts = [
        'maquinas_rotas' => 'array'
    ];

    public function ueb () 
    {
        return $this->belongsTo(Ueb::class);
    }

    public function maquina ()
    {
        return $this->belongsTo(Maquinas::class);
    }
}
