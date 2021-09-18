<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ausencia extends Model
{

    protected $fillable = [
       'certificados_medicos',
       'lic_maternidad',
       'vacaciones',
       'aus_autorizadas',
       'aus_injustificadas',
       'otras',
       'aislados',
       'positivos',
       'madres_ninnos',
    ];

    public function ueb()
    {
        return $this->belongsTo(Ueb::class);
    }
}

