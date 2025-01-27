<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Registro
Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);

// Rutas protegidas con autenticación
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/updatePerfile', [AuthController::class, 'updatePerfil']);
});   //ruta para update peril- http://127.0.0.1:8000/api/updatePerfile

Route::middleware('auth:sanctum')->post('/cambiarContra', [AuthController::class, 'cambiarContra']);
//ruta para cambiar contra- http://127.0.0.1:8000/api/cambiarContra