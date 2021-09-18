<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ueb extends Model
{
    protected $fillable = [
        'name',
        'total_maquinas_riego',
        'maquinas_listas',
        'afectaciones',
    ];

    protected $casts = [
        'maquinas_rotas' => 'array'
    ];

    public function ausencia() 
    {
        return $this->hasMany(Ausencia::class);
    }
    public function quimicos() 
    {
        return $this->hasMany(Quimico::class);
    }
}

