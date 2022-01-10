<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidenciaCulturale extends Model
{
    protected $fillable = [
        'ueb_id',
        'cultivo_id',
        'cc',
        'tipo_peloton',
        'c_plan',
        'c_acum',
        'c_diario',
        'p_plan',
        'p_acum',
        'p_diario',
        'l_plan',
        'l_acum',
        'l_diario',
        'ch_plan',
        'ch_acum',
        'ch_diario',
        'd_d',
    ];

    public function ueb () 
    {
       return $this->belongsTo(Ueb::class);
    }
    public function cultivo () 
    {
      return $this->belongsTo(Cultivo::class);
    }
    public function culturale() 
     {
         return $this->belongsTo(Culturale::class);
     }
}
