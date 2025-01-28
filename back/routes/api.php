<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CuisineController;

// Rutas protegidas por middleware 'auth:sanctum'
Route::middleware('auth:sanctum')->group(function () {
    // Categorías
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // Cocinas
    Route::post('/cuisines', [CuisineController::class, 'store']);
    Route::get('/cuisines', [CuisineController::class, 'index']);
    Route::get('/cuisines/{id}', [CuisineController::class, 'show']);
    Route::put('/cuisines/{id}', [CuisineController::class, 'update']);
    Route::delete('/cuisines/{id}', [CuisineController::class, 'destroy']);

    // Recetas
    Route::get('/recipes', [RecipeController::class, 'index']);
    Route::get('/recipes/{id}', [RecipeController::class, 'show']);
    Route::post('/recipes', [RecipeController::class, 'store']);
    Route::put('/recipes/{id}', [RecipeController::class, 'update']);
    Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']);

    // Rutas para dar y quitar "like" a recetas
    Route::post('/recipes/{id}/like', [RecipeController::class, 'likeRecipe']);
    Route::post('/recipes/{id}/unlike', [RecipeController::class, 'unlikeRecipe']);

    // Rutas protegidas para perfil de usuario
    Route::post('/updatePerfile', [AuthController::class, 'updatePerfil']); // Actualizar perfil
    Route::post('/cambiarContra', [AuthController::class, 'cambiarContra']); // Cambiar contraseña
});

// Rutas públicas
// Buscar y filtrar recetas con filtros avanzados
Route::get('/recipes/filter', [RecipeController::class, 'filterAndSearch']);

// Autenticación
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
});
