<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $validator = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);


        if (! $token = auth()->attempt($validator)) {
            return response()->json(['error' => 'username or password do not match or empty'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate(
            [
                'old_password' => 'required',
                'new_password' => 'required'
            ]
        );

        $user = auth()->user();
        if (!Hash::check($request->post('old_password'), $user->password)) {
            return response()->json(['message' => "old password did not match"]);
        }

        $user->password = bcrypt($request->post("new_password"));
        $user->save();

        auth()->logout();

        return response()->json(['message' => "reset success, user logged out"]);
    }


    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',
            'division_id' => 'required'
        ]);

        $user = User::create(array_merge(
                    $validator,
                    ['password' => bcrypt($request->post("password"))]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 86400
        ]);
    }
}