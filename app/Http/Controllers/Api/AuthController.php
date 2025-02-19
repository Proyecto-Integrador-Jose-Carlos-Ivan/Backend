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