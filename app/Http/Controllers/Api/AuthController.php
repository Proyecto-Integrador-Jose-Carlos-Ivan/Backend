<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

/**
 * @OA\Tag(
 *   name="Autenticación",
 *   description="Operaciones relacionadas con la autenticación de usuarios."
 * )
 */
class AuthController extends BaseController
{
    /**
     * Redirige al usuario a la página de inicio de sesión de Google.
     *
     * @OA\Get(
     *     path="/api/auth/google/redirect",
     *     summary="Redirige a Google para iniciar sesión",
     *     description="Redirige al usuario a la página de inicio de sesión de Google.",
     *     tags={"Autenticación"},
     *     @OA\Response(
     *         response=302,
     *         description="Redirección a Google",
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtiene la información del usuario de Google.
     *
     * @OA\Get(
     *     path="/api/auth/google/callback",
     *     summary="Gestiona la respuesta de Google tras el inicio de sesión",
     *     description="Obtiene la información del usuario de Google tras el inicio de sesión y genera un token.",
     *     tags={"Autenticación"},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="token", type="string", description="Token de autenticación"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Usuario no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();
        $errorMessage = 'User not found in the system. Please, contact the coordinator.';
        if (!$user) {
            return response()->view('auth.popup', compact('errorMessage'));
        }

        // Actualiza la información del usuario si es necesario
        $user->update([
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
        ]);

        // Generate token for the user
        $token = $user->createToken('MyAuthApp')->plainTextToken;

        return response()->view('auth.popup', compact('token', 'user'));
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Inicia sesión con credenciales",
     *     description="Inicia sesión con un email y contraseña.",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="usuario@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="token", type="string", description="Token de autenticación"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Credenciales inválidas"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function loginCredentials(Request $request)
    {
        // Validación básica de campos
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return $this->sendError('Unauthorized', ['error' => 'Invalid credentials'], 401);
        }

        // Obtener usuario autenticado y crear token
        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        $result = [
            'token' => $token,
            'user'  => $user,
        ];

        return $this->sendResponse($result, 'User signed in');    }

    /**
     * Cierra la sesión del usuario.
     *
     *  @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Cierra la sesión del usuario",
     *     description="Cierra la sesión del usuario actual, invalidando el token.",
     *     tags={"Autenticación"},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User successfully signed out.")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return $this->sendResponse([], 'User successfully signed out.');
    }
}