<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
   // protected $guarded = [];
    
    protected $fillable = [
        'name', 'description'
    ];

    protected $casts = [
        'updated_at' => 'date:d-m-y',
        'created_at' => 'date:d-m-y'
    ];
}
    