<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('auth:api')->apiResource('/posts', PostController::class);

Route::controller(AuthController::class)->group(function() {
    Route::post('/auth/login',  'login');
    Route::post('/auth/register',  'register');
    Route::post('/auth/logout',  'logout');
});