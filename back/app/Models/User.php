<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'personal_access_token', 
    ];

    protected $hidden = [
        'password', 
        'remember_token', 
        'personal_access_token', 
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
