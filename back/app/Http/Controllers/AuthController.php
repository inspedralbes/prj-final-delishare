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
        $user->update(['personal_access_token' => $token]);
        $user = User::where('name', $request->user)->first();
        // Respuesta con el usuario y el token
        return response()->json([
            'user' => [
            'id_user' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ],
        'token' => $token,
            ],201);
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


        // // Obtén el usuario autenticado
         $user = auth()->user();

        // // Crea el token si el usuario no lo tiene
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
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255|unique:users,name,' . $request->user()->id,
            'email' => 'sometimes|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $user->update($request->only(['name', 'email']));

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

}
