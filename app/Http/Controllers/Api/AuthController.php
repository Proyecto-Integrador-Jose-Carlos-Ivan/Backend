<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends BaseController
{
    /**
     * Redirige al usuario a la página de inicio de sesión de Google.
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtiene la información del usuario de Google.
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find the user by google_id
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // If the user exists, log them in
                Auth::login($user);

                $token = $user->createToken('API Token')->plainTextToken;

                $result = [
                    'token' => $token,
                    'name' => $user->name,
                ];

                return $this->sendResponse($result, 'User signed in with Google.');
            } else {
                // If the user doesn't exist, return an error
                return $this->sendError('Google Auth Error', 'User not found. Please sign up first.', 404);
            }

        } catch (\Exception $e) {
            return $this->sendError('Google Auth Error', $e->getMessage(),  401);
        }
    }

    public function login(Request $request)
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
            'name'  => $user->name,
        ];

        return $this->sendResponse($result, 'Usuario autenticado correctamente.');
    }

    /**
     * Cierra la sesión del usuario.
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