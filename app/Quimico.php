<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quimico extends Model
{
   
    protected $fillable = [
        'cc',
        'tipo_aplicacion',
        'tipo_producto',
        'cant',
        'cant_equipos',
        'area_aplicada',
        'area_acum',
        'comienza',
        'termina',
        'ueb_id'
    ];

    public function ueb () 
    {
        return $this->belongsTo(Ueb::class);
    }
    public function quimicos () 
    {
        return $this->belongsTo(Ueb::class);
    }

    public function incidencia_quimicos () 
    {
        return $this->belongsTo(IncidenciaQuimico::class);
    }
}
