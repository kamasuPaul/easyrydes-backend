<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     * path="/api/auth/login",
     * tags ={"Login"},
     * summry="Login"
     * )
     * @OA\Parameter(
     * name="email",
     * in="query",
     * required="true,
     * @OA\Schema()   
     * )
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return jsend_fail($validator->errors(), 422);
        }

        $token = Auth::attempt($validator->validated());

        if (!$token) {
            return jsend_fail(['error' => 'Unauthorized, Invalid email or password'], 401);
        }
        return jsend_success($this->createNewToken($token));
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return jsend_fail($validator->errors(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return jsend_success([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return jsend_success(Auth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return jsend_success(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return jsend_success($this->createNewToken(Auth::refresh()));
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => auth()->user()
        ];
    }

    /**
     * Send email with link to reset password
     */
    public function forgot_password()
    {
        $credentials = request()->validate(['email' => 'required|email']);
        Password::sendResetLink($credentials);
        return jsend_success(['message' => "Password reset link sent by email"], 200);
    }

    /**
     * Reset password
     */
    public function reset_password(Request $request, $token)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:password_resets,email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return jsend_fail($validator->errors(), 400);
        }

        $reset_password_status =
            Password::reset($validator->validated(), function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return jsend_fail(['message' => 'Invalid token provided'], 400);
        }
        return jsend_success(['message' => 'Password successfully changed'], 200);
    }
}
