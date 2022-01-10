<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ueb extends Model
{
    protected $fillable = [
      'name',
    ];

    protected $casts = [
      'maquinas_rotas' => 'array',
      'created_at' => 'date:d-m-y',
      'updated_at' => 'date:d-m-y',
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

    public function cosecha() 
    {
     return $this->hasMany(Cosecha::class);
    }
    
    public function culturale() 
    {
     return $this->hasMany(Culturale::class);
    }

    public function tierra() 
    {
     return $this->hasMany(Tierra::class);
    }

    public function general() 
    {
        return $this->belongsTo(General::class);
    }

    public function incidencia_siembra() 
    {
     return $this->hasMany(IncidenciaSiembra::class);
    }
    public function incidencia_maquina() 
    {
     return $this->hasMany(IncidenciaMaquina::class);
    }
    public function incidencia_quimicos () 
    {
      return $this->belongsTo(IncidenciaQuimico::class);
    }
    public function incidencia_ausencia()
    {
        return $this->belongsTo(IncidenciaAusencia::class);
    }
    public function incidencia_energia ()
    {
        return $this->hasMany(IncidenciaEnergia::class);
    }
    public function incidencia_cosecha() 
    {
      return $this->hasMany(General::class);
    }
    public function incidencia_culturale() 
    {
      return $this->hasMany(IncidenciaCulturale::class);
    }
    public function incidencia_tierra() 
    {
      return $this->hasMany(IncidenciaTierra::class);
    }
}

