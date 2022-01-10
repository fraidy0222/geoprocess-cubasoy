<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    protected $fillable = [
        'cultivo_id',
        'ueb_id',
        'tonelada_id',
        'valores_id',
        'siembra_id',
        'culturales_id',
        'tierra_id',
        'energia_id',
        'cosecha_id',
    ];

     
    public function cultivo() 
    {
     return $this->hasMany(Cultivo::class);
    }
     
    public function ueb() 
    {
     return $this->hasMany(Ueb::class);
    }

    public function tonelada() 
    {
     return $this->hasMany(Tonelada::class);
    }

    public function valores() 
    {
     return $this->hasMany(Valores::class);
    }

    public function siembra() 
    {
     return $this->hasMany(Siembra::class);
    }

    public function culturale() 
    {
     return $this->hasMany(Culturale::class);
    }
    
    public function tierra() 
    {
     return $this->hasMany(Tierra::class);
    }

    public function energia() 
    {
     return $this->hasMany(Energia::class);
    }
    
    public function cosehca() 
    {
     return $this->hasMany(Cosecha::class);
    }

}
