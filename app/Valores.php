<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valores extends Model
{
    protected $timetamps = false;

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
    public function general() 
    {
        return $this->belongsTo(General::class);
    }

    public function incidencia_valore() 
    {
        return $this->belongsTo(General::class);
    }
}
