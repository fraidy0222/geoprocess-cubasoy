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
    

    public function ventas_diarias () 
    {
        return $this->hasMany(Valores::class);
    }
    public function siembra () 
    {
        return $this->hasMany(Siembra::class);
    }

    public function toneladas () 
    {
        return $this->hasMany(Tonelada::class);
    }

    public function incidencia_siembra() 
    {
       return $this->hasMany(IncidenciaSiembra::class);
    }

    public function cosecha() 
    {
       return $this->hasMany(Cosecha::class);
    }
    
    public function culturale() 
    {
     return $this->hasMany(Culturale::class);
    }

    public function general() 
    {
        return $this->belongsTo(General::class);
    }

    public function diario() 
    {
        return $this->hasOne(Diario::class);
    }
    public function incidencia_valores() 
    {
        return $this->hasOne(IncidenciasValore::class);
    }

    public function incidencia_tonelada() 
    {
        return $this->hasMany(IncidenciaTonelada::class);
    }

    public function incidencia_cosecha() 
    {
      return $this->hasMany(General::class);
    }

    public function incidencia_culturale() 
    {
      return $this->hasMany(IncidenciaCulturale::class);
    }
}
