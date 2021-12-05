<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cultivo extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $casts = [
      'created_at' => 'date:d-m-y',
      'updated_at' => 'date:d-m-y',
    ];
    

    public function ventas_diarias () {
        return $this->hasMany(Valores::class);
    }
    public function siembra () {
        return $this->hasMany(Siembra::class);
    }

    public function toneladas () {
        return $this->hasMany(Tonelada::class);
    }

    public function incidencia_siembra() 
    {
     return $this->hasMany(IncidenciaSiembra::class);
    }
}
