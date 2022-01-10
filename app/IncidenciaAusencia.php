<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidenciaAusencia extends Model
{
    protected $fillable = [
        'ueb_id',
        'ausencia_id',
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

    public function ueb () 
    {
        return $this->belongsTo(Ueb::class);
    } 
    public function ausencia () 
    {
        return $this->belongsTo(Ausencia::class);
    } 
}
