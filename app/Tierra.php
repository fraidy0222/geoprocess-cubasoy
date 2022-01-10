<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tierra extends Model
{
    protected $fillable = [
        'ueb_id',
        'cc',
        'tipo_peloton',
        'r_plan',
        'r_acum',
        'r_diario',
        'g_plan',
        'g_acum',
        'g_diario',
        'c_plan',
        'c_acum',
        'c_diario',
        's_plan',
        's_acum',
        's_diario',
        'nivelacio_rail'
    ];

    public function ueb () 
    {
        return $this->belongsTo(Ueb::class);
    }

    public function general() 
    {
        return $this->belongsTo(General::class);
    }

    public function incidencia_tierra() 
    {
      return $this->hasMany(IncidenciaTierra::class);
    }
}
