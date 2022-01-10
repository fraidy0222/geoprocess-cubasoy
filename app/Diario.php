<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diario extends Model
{
    protected $fillable = [
        'cultivo_id',
        't_diario',
        't_plan',
        't_real',
        'porciento'
    ];

    public function cultivo () 
    {
        return $this->belongsTo(Cultivo::class);
    }
}
