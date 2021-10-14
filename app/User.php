<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

   public function role() 
   {
     return $this->belongsTo(Role::class);
   }

   public function Admin () {
      return $this->is_admin;
   }

   public function isAdmin()
   {
      return strtolower($this->role->name) === 'administrator';
   }

   public function editor()
   {
     return strtolower($this->role->name) === 'editor';
   }

   public function invitado()
   {
      return strtolower($this->role->name) === 'invitado';
   }
}
