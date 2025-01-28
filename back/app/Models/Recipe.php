<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'cuisine_id',
        'title',
        'description',
        'ingredients',
        'steps',
        'image',
        'prep_time',
        'cook_time',
        'servings',
        'nutrition',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cuisine()
    {
        return $this->belongsTo(Cuisine::class);
    }

    public function scopeFilter($query, $filters)
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
    
        if (isset($filters['max_time'])) {
            $query->where('prep_time', '<=', $filters['max_time'])
                  ->orWhere('cook_time', '<=', $filters['max_time']);
        }
    
        if (isset($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
        }
    
        if (isset($filters['sort']) && isset($filters['direction'])) {
            $query->orderBy($filters['sort'], $filters['direction']);
        }
    
        return $query;
    }
}