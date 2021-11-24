<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tonelada extends Model
{
    protected $fillable = [
        'cultivo_id',
        'venta_d',
        'acum_mes',
        'acum_fecha',
        'acopio',
        'eam',
        'encarg_estatal',
        'industria',
        'cayo_cruz',
        'i_ceballos',
        'fruta_select',
        'otros',
        'semilla',
        'es_camaguey',
    ];

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }
}
