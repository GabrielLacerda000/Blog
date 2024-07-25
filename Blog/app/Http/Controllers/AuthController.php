<?php

namespace App\Http\Controllers;

use App\Actions\Authenticate;
use App\Http\Actions\RegisterUser;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(public User $user){}

    public function login(AuthRequest $request) {

        $credentials = $request->validated();
        
        if($token = Auth::attempt($credentials)) {
            return $this->respondWithToken($token, $credentials);
        }

        return response()->Json([['message' => 'Credentials does not match our records'], 403]);
    }

    public function register(RegisterRequest $request) {
        
        $newUser = $this->user->create($request->validated());
       
        if(!$newUser) {
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occured while trying to create user'
            ], 500);
        } 

        $token= auth()->login($newUser);

        return $this->respondWithToken($token, $newUser);

    }

    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token, $user) {
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
