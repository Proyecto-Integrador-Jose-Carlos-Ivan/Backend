<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
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
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::updateOrCreate(
                ['google_id' => $googleUser->id], // Usar google_id para buscar
                [
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'avatar' => $googleUser->avatar,
                    'telefono' => $googleUser->telefono,
                ]
            );

            Auth::login($user); // Autenticar para la web

            $token = $user->createToken('API Token')->plainTextToken;

            $result = [
                'token' => $token,
                'name' => $user->name,
            ];

            return $this->sendResponse($result, 'User signed in with Google.');

        } catch (\Exception $e) {
            return $this->sendError('Google Auth Error', $e->getMessage(),  401);
        }
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