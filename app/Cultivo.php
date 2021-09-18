<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cultivo extends Model
{
    protected $fillable = [
        'name'
    ];

    public function ventas_diarias () {
        return $this->hasMany(Valores::class);
    }
}
