<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    // Listar todas las recetas con relaciones
    public function index()
    {
        return Recipe::with(['user', 'category', 'cuisine'])->get();
    }

    // Mostrar una receta específica por ID con relaciones
    public function show($id)
    {
        return Recipe::with(['user', 'category', 'cuisine'])->findOrFail($id);
    }

    // Crear una nueva receta
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'cuisine_id' => 'required|exists:cuisines,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|array',
            'steps' => 'required|array',
            'prep_time' => 'required|integer',
            'cook_time' => 'required|integer',
            'servings' => 'required|integer',
            'nutrition' => 'nullable|array',
            'image' => 'nullable|string',
        ]);

        return Recipe::create($data);
    }

    // Actualizar una receta existente
    public function update(Request $request, $id)
    {
        $recipe = Recipe::findOrFail($id);

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'cuisine_id' => 'required|exists:cuisines,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|array',
            'steps' => 'required|array',
            'prep_time' => 'required|integer',
            'cook_time' => 'required|integer',
            'servings' => 'required|integer',
            'nutrition' => 'nullable|array',
            'image' => 'nullable|string',
        ]);

        $recipe->update($data);

        return $recipe;
    }

    // Eliminar una receta
    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return response()->json(['message' => 'Recipe deleted successfully']);
    }

    // Dar "like" a una receta
    public function likeRecipe(Request $request, $recipeId)
    {
        $userId = $request->user()->id;

        $recipeUser = DB::table('recipe_user')
            ->where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->first();

        if ($recipeUser && $recipeUser->liked) {
            return response()->json(['message' => 'Recipe already liked']);
        }

        if ($recipeUser) {
            DB::table('recipe_user')
                ->where('user_id', $userId)
                ->where('recipe_id', $recipeId)
                ->update(['liked' => true, 'updated_at' => now()]);
        } else {
            DB::table('recipe_user')->insert([
                'user_id' => $userId,
                'recipe_id' => $recipeId,
                'liked' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Recipe::where('id', $recipeId)->increment('likes_count');

        return response()->json(['message' => 'Recipe liked successfully']);
    }

    // Quitar "like" de una receta
    public function unlikeRecipe(Request $request, $recipeId)
    {
        $userId = $request->user()->id;

        $recipeUser = DB::table('recipe_user')
            ->where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->first();

        if (!$recipeUser || !$recipeUser->liked) {
            return response()->json(['message' => 'Recipe not liked yet']);
        }

        DB::table('recipe_user')
            ->where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->update(['liked' => false, 'updated_at' => now()]);

        Recipe::where('id', $recipeId)->decrement('likes_count');

        return response()->json(['message' => 'Recipe unliked successfully']);
    }
    public function search(Request $request)
    {
        $query = Recipe::query()->with(['user', 'category', 'cuisine']);
    
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
    
        if ($request->has('cuisine_id')) {
            $query->where('cuisine_id', $request->cuisine_id);
        }
    
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
    
        if ($request->has('total_time')) {
            $query->whereRaw('prep_time + cook_time <= ?', [$request->total_time]);
        }
    
        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
    
        return $query->get();
    }
}    