<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Registro
Route::post('register', [AuthController::class, 'register']);
Route::get('test', function () {
    return response()->json(['message' => 'Ruta de prueba funcionando']);
});
