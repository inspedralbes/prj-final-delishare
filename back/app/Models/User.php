<?php
namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;



class User extends Authenticatable

{
    use HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
    
    public function savedRecipes()
    {
        return $this->belongsToMany(Recipe::class)->withPivot('saved', 'liked');
    }

}

