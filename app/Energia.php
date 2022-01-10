<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Energia extends Model
{
    protected $fillable = [
        'plan_mes_energia',
        'plan_real_energia',
        'porciento_energia',
        'plan_mes_petroleo',
        'plan_real_petroleo',
        'porciento_petroleo'
    ];

    public function ueb ()
    {
        return $this->belongsTo(Ueb::class);
    }

    public function general() 
    {
        return $this->belongsTo(General::class);
    }
    
    public function incidencia_energia ()
    {
        return $this->hasMany(IncidenciaEnergia::class);
    }
}
