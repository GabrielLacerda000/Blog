<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function auth(Request $request) {
        
        if(Auth::attempt($request->only('email', 'password'))) {
            return response()->Json([['message' => 'Authorized'], 200]);
        }

        return response()->Json([['message' => 'Not Authorized'], 403]);
    }
}
