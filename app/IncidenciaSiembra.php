<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidenciaSiembra extends Model
{
    protected $fillable = [
        'ueb_id',
        'cultivo_id',
        'siembra_id',
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

    public function cultivo () 
    {
        return $this->belongsTo(Cultivo::class);
    }
    
    public function ueb () 
    {
        return $this->belongsTo(Ueb::class);
    }

    public function siembra () 
    {
        return $this->belongsTo(Siembra::class);
    }
}
