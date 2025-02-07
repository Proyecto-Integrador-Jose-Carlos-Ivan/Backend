<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;


/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="Autenticació de l'usuari",
 *     tags={"Autenticació"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="1@manager.com"),
 *             @OA\Property(property="password", type="string", example="1234"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login correcte",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="token", type="string", example="jwt-token"),
 *                 @OA\Property(property="name", type="string", example="John Doe")
 *             ),
 *             @OA\Property(property="message", type="string", example="User signed in")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autoritzat",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Unauthorised."),
 *             @OA\Property(property="info", type="object",
 *                 @OA\Property(property="error", type="string", example="incorrect Email/Password")
 *             )
 *         )
 *     )
 * )
 */
class AuthController extends BaseController
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cerca o crea l'usuari a la base de dades
            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                ]
            );

            // Autentica l'usuari
            Auth::login($user);

            // Generar token Sanctum
            // Si volem autenticar en l'API podriem generar un token
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            // Retornar el token i l'estat
            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token,
                    'name' => $user->name,
                ],
                'message' => 'User signed in'
            ], 200);

        } catch (\Exception $e) {
            // Maneig d'errors
            return response()->json([
                'success' => false,
                'message' => 'Unauthorised',
                'info' => [
                    'error' => $e->getMessage()
                ]
            ], 401);
        }
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $result['token'] = $user->createToken('MyAuthApp')->plainTextToken;
            $result['name'] = $user->name;

            return $this->sendResponse($result, 'User created successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Registration Error', $e->getMessage());
        }
    }
    public function logout(Request $request)
    {

        $user = request()->user(); //or Auth::user()
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        $success['name'] = $user->name;
        return $this->sendResponse($success, 'User successfully signed out.');
    }

}