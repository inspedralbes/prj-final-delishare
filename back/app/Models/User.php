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
        'profile_photo_path',
        'description',
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

    // User model
public function savedRecipes()
{
    return $this->belongsToMany(Recipe::class, 'recipe_user')
        ->withPivot('saved', 'liked')
        ->wherePivot('saved', true);  // Filtro por recetas guardadas
}


    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
