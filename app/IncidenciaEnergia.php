<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidenciaEnergia extends Model
{
    protected $fillable = [
        'ueb_id',
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

    public function energia ()
    {
        return $this->belongsTo(Energia::class);
    }
}
