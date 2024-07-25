<?php

namespace App\Actions;

use App\Models\User;

class RegisterUser {

    public function __construct(public User $user, public $credentials){}

        public function handle() {
            $newUser = $this->user->create($this->credentials);
        
            if($newUser) {
                $token= auth()->login($newUser);
                return $this->respondWithToken($token, $newUser);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'An error occure while trying to create user'
                ], 500);
            } 
        } 

        protected function respondWithToken($token, $user) {
            return response()->json([
                'status' => 'user created successfully',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'bearer',
                // 'expires_in' => auth()->factory()->getTTL() * 60
            ]);
        }
}