<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siembra extends Model
{
    protected $fillable = [
        'ueb_id',
        'cultivo_id',
        'cc',
        'area',
        'siembrap',
        'siembraa',
        'siembrad',
        'cantsemillad',
        'cantsemillaa',
        'cantsemillaud',
        'cantsemillaua',
    ];

    public function ueb () 
    {
        return $this->belongsTo(Ueb::class);
    }

    public function cultivo () 
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function incidencia_siembra() 
    {
     return $this->hasMany(IncidenciaSiembra::class);
    }
    public function general() 
    {
        return $this->belongsTo(General::class);
    }
    
}
