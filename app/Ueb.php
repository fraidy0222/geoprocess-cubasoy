<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ueb extends Model
{
    protected $fillable = [
        'name', 
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
    public function energia() 
    {
        return $this->hasMany(Energia::class);
    }
    public function maquinas() 
    {
        return $this->hasMany(Maquinas::class);
    }
    public function siembra() 
    {
        return $this->hasMany(Siembra::class);
    }
}

