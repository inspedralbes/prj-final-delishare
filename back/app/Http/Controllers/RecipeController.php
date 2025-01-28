<?php

namespace App\Http\Controllers;

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
            'nutrition' => 'nullable|array',
            'image' => 'nullable|string',
        ]);

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
            'nutrition' => 'nullable|array',
            'image' => 'nullable|string',
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
    public function filterAndSearch(Request $request)
{
    try {
        \Log::info('Request data:', $request->all()); // Log de los datos recibidos

        // Validar los parámetros de la solicitud
        $request->validate([
            'category_id' => 'nullable|integer|exists:categories,id',
            'cuisine_id' => 'nullable|integer|exists:cuisines,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'max_time' => 'nullable|integer',
            'search' => 'nullable|string',
            'sort' => 'nullable|in:title,prep_time,cook_time',
            'direction' => 'nullable|in:asc,desc',
        ]);

        \Log::info('Filters applied:', $request->all()); // Log de los filtros aplicados

        // Usar el scope 'filter' del modelo Recipe
        $recipes = Recipe::filter($request->all())
            ->with(['user', 'category', 'cuisine'])
            ->get();

        \Log::info('Recipes found:', $recipes->toArray()); // Log de las recetas encontradas

        return response()->json($recipes);

    } catch (\Exception $e) {
        \Log::error('Error en filterAndSearch: ' . $e->getMessage()); // Log del error
        \Log::error('Stack trace:', ['trace' => $e->getTraceAsString()]); // Log del stack trace

        return response()->json([
            'message' => 'Ocurrió un error al procesar la solicitud.',
            'error' => $e->getMessage()
        ], 500);
    }
}
}