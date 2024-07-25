<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Authenticate {

    public function __construct(public User $user, public $credentials){}

        public function handle() {
            if($token = Auth::attempt($this->credentials)) {
           
            return $this->respondWithToken($token, $this->credentials);
        }

        return response()->Json([['message' => 'Unauthorized'], 403]);
        } 

        protected function respondWithToken($token, $user) {
            return response()->json([
                'status' => 'user logged successfully',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'bearer',
                // 'expires_in' => auth()->factory()->getTTL() * 60
            ]);
        }
}