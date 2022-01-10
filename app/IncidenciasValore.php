<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidenciasValore extends Model
{
    protected $fillable = [
        'venta_diaria_cup',
        'venta_mes_cup',
        'acumulado',
        'cultivo_id'
    ];

    public function cultivo () 
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function valore () 
    {
        return $this->belongsTo(Valores::class);
    }
}
