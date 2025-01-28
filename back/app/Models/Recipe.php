<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'cuisine_id', 'title', 'description',
        'ingredients', 'steps', 'image', 'prep_time', 'cook_time',
        'servings', 'nutrition'
    ];

    protected $casts = [
        'ingredients' => 'array',
        'steps' => 'array',
        'nutrition' => 'array',
    ];

    // Relación con el usuario (creador de la receta)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con la categoría de la receta
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación con la cocina (cuisine) de la receta
    public function cuisine()
    {
        return $this->belongsTo(Cuisine::class);
    }

    // Relación con los usuarios que han guardado o dado like a la receta
    public function users()
    {
        return $this->belongsToMany(User::class, 'recipe_user')
                    ->withPivot('saved', 'liked')
                    ->withTimestamps();
    }

    // Scope para aplicar filtros dinámicos a la búsqueda
    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['cuisine_id'])) {
            $query->where('cuisine_id', $filters['cuisine_id']);
        }

        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['total_time'])) {
            // El total_time es la suma de prep_time y cook_time
            $query->whereRaw('prep_time + cook_time <= ?', [$filters['total_time']]);
        }

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }
    }
}
