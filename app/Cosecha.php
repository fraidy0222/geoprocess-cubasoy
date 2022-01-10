<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cosecha extends Model
{
    protected $fillable = [
        'ueb_id',
        'cultivo_id',
        'cc',
        'area_total',
        'a_c_diario',
        'a_c_acum',
        'a_c_pendiente',
        't_diario',
        't_acum',
        't_rend',
        'rend_acum',
        'arranque_m',
        'cant_equipos'
    ];

    public function ueb () 
    {
        return $this->belongsTo(Ueb::class);
    }

    public function cultivo () 
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function general() 
    {
        return $this->belongsTo(General::class);
    }

    public function incidencia_cosecha() 
    {
        return $this->hasMany(General::class);
    }
}
