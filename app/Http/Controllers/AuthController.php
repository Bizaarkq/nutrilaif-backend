<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // public function register(Request $request)
    // {
    //     // Validar los datos de entrada
    //     $this->validate($request, [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:4',
    //     ]);

    //     // Crear el usuario
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     // Generar el token
    //     $token = JWTAuth::fromUser($user);

    //     // Respuesta
    //     return response()->json(compact('user', 'token'), 201);
    // }

    public function login(Request $request)
    {
        // validar que viene e codigo de usuario y la contraseña en la petición
        $validate = Validator::make($request->all(), [
            'codigo' => 'required',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => 'Datos incompletos'], 400);
        }

        //validar que el codigo de usuario exista
        $user = User::where('codigo', $request->codigo)->first();
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Validar la contraseña
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Contraseña incorrecta'], 401);
        }

        // Generar el token
        $token = JWTAuth::fromUser($user);

        // Respuesta
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        $user = auth()->user();

        // roles
        $roles = $user->getRoleNames();

        return response()->json([
            'name' => $user->name,
            'codigo' => $user->codigo,
            'email' => $user->email,
            'roles' => $roles
        ]);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
