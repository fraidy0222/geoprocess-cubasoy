<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidenciaQuimico extends Model
{
    protected $fillable = [
        'ueb_id',
        'quimico_id',        
        'cc',
        'tipo_aplicacion',
        'tipo_producto',
        'cant',
        'cant_equipos',
        'area_aplicada',
        'area_acum',
    ];

    public function ueb () 
    {
        return $this->belongsTo(Ueb::class);
    }

    public function quimico () 
    {
        return $this->belongsTo(Quimico::class);
    }
}
