<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::controller(PostController::class)->group(function() {
//     Route::get('/posts', 'index');
//     Route::post('/posts/create', 'store');
//     Route::get('/posts/{id}', 'show');
// });

Route::apiResource('/posts', PostController::class);

Route::post('/login', [AuthController::class, 'auth']);