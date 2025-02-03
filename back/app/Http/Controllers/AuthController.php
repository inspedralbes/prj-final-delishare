<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Registro de usuario
    public function register(Request $request)
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'user' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crear el usuario
        $user = User::create([
            'name' => $request->user,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generar un token único y guardarlo en el usuario
        $token = $user->createToken('auth_token')->plainTextToken;

        // Respuesta con el usuario y el token
        return response()->json([
            'user' => [
                'id_user' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ], 201);
    }

    // Login de usuario
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

        // Verifica si las credenciales son válidas
        if (!auth()->attempt(['name' => $request->user, 'password' => $request->password])) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        // Obtén el usuario autenticado
        $user = auth()->user();

        // Crea el token si el usuario no lo tiene
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => [
                'id_user' => $user->id,
                'user' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ], 201);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function updatePerfil(Request $request)
    {
        // Validación de los datos
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:30|unique:users,name,' . $request->user()->id,
            'email' => 'sometimes|email|max:255|unique:users,email,' . $request->user()->id,
            'bio' => 'sometimes|string|max:150', // validación para bio
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // validación para imagen
        ]);

        // Si la validación falla, devuelve los errores
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user(); // Obtiene el usuario autenticado

        // Actualiza los campos básicos (name, email, bio)
        $user->update($request->only(['name', 'email', 'bio']));

        // Si hay una nueva imagen, maneja la subida
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('profile_pictures', 'public'); // Guarda la imagen en 'storage/app/public/profile_pictures'

            // Actualiza la ruta de la imagen en la base de datos
            $user->image = $imagePath;
            $user->save();
        }

        return response()->json([
            'message' => 'Perfil actualizado correctamente.',
            'user' => $user,
        ]);
    }


    public function cambiarContra(Request $request)
    {
        $usuario = $request->user();
        if (!Hash::check($request->contrasena_actual, $usuario->password)) {
            return response()->json(['mensaje' => 'La contraseña actual es incorrecta.'], 403);
        }
        $usuario->update(['password' => Hash::make($request->nueva_contrasena)]);
        return response()->json(['mensaje' => 'Contraseña actualizada correctamente.'], 200);
    }

    public function userStats(Request $request)
    {
        $user = auth()->user(); // Obtiene el usuario autenticado

        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        return response()->json([
            'post_count' => $user->recipes()->count(),
            'total_likes' => $user->recipes()->withCount([
                'users as likes_count' => function ($query) {
                    $query->where('liked', true);
                }
            ])->get()->sum('likes_count'),
            'total_saves' => $user->recipes()->withCount([
                'users as saves_count' => function ($query) {
                    $query->where('saved', true);
                }
            ])->get()->sum('saves_count'),
            'posts' => $user->recipes()->get(),
            'profile_image' => $user->profile_photo_path,
            'user_name' => $user->name,
            'user_description' => $user->description,
        ], 200);

    }

}
