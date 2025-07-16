<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/v1/login",
     * summary="Iniciar sesión de usuario",
     * tags={"Auth"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"email","password"},
     * @OA\Property(property="email", type="string", format="email", example="john.doe@empresa.com"),
     * @OA\Property(property="password", type="string", format="password", example="secret123"),
     * ),
     * ),
     * @OA\Response(response=200, description="Login exitoso con token"),
     * @OA\Response(response=401, description="Credenciales no válidas")
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciales no válidas.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
}