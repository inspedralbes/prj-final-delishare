<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Recipe;

use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        return Recipe::with(['user', 'category', 'cuisine'])->get();
    }

    public function show($id)
    {
        return Recipe::with(['user', 'category', 'cuisine'])->findOrFail($id);
    }

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
        'nutrition' => 'nullable|array',  // Make sure to validate nutrition as an array
        'image' => 'nullable|string', // Acepta texto o se puede dejar vacío

    ]);

    // Store the recipe, including the nutrition data if available
    return Recipe::create($data);
}



   
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
        'nutrition' => 'nullable|array',  // Handle nutrition field if available
        'image' => 'nullable|string', // Acepta texto o se puede dejar vacío

    ]);

    $recipe->update($data);

    return $recipe;
}

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();
        return response()->json(['message' => 'Recipe deleted successfully']);
    }
    public function likeRecipe(Request $request, $recipeId)
    {
        $userId = $request->user()->id;
    
        // Verificar si el registro existe en la tabla pivot
        $recipeUser = DB::table('recipe_user')
            ->where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->first();
    
        if ($recipeUser && $recipeUser->liked) {
            return response()->json(['message' => 'Recipe already liked']);
        }
    
        if ($recipeUser) {
            // Actualizar el registro existente
            DB::table('recipe_user')
                ->where('user_id', $userId)
                ->where('recipe_id', $recipeId)
                ->update(['liked' => true, 'updated_at' => now()]);
        } else {
            // Crear un nuevo registro en la tabla pivot
            DB::table('recipe_user')->insert([
                'user_id' => $userId,
                'recipe_id' => $recipeId,
                'liked' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        // Incrementar el contador de likes
        Recipe::where('id', $recipeId)->increment('likes_count');
    
        return response()->json(['message' => 'Recipe liked successfully']);
    }
    

    public function unlikeRecipe(Request $request, $recipeId)
    {
        $userId = $request->user()->id;
    
        // Verificar si el registro existe y está marcado como liked
        $recipeUser = DB::table('recipe_user')
            ->where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->first();
    
        if (!$recipeUser || !$recipeUser->liked) {
            return response()->json(['message' => 'Recipe not liked yet']);
        }
    
        // Actualizar el registro para indicar que ya no tiene like
        DB::table('recipe_user')
            ->where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->update(['liked' => false, 'updated_at' => now()]);
    
        // Decrementar el contador de likes
        Recipe::where('id', $recipeId)->decrement('likes_count');
    
        return response()->json(['message' => 'Recipe unliked successfully']);
    }

    public function search(Request $request)
{
    $query = Recipe::query();

    // Filtros opcionales
    if ($request->has('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    if ($request->has('cuisine_id')) {
        $query->where('cuisine_id', $request->cuisine_id);
    }

    if ($request->has('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    if ($request->has('max_time')) {
        $query->whereRaw('(prep_time + cook_time) <= ?', [$request->max_time]);
    }

    if ($request->has('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }

    return $query->with(['user', 'category', 'cuisine'])->get();
}

    
}