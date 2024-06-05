<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends Controller {

    public function index() {
        // return response()->json(Post::with('user')->get());
        return PostResource::collection(Post::all());
    }
    
    public function store(PostRequest $request) {

        $post = Post::create($request->all());

        // return response()->json(new PostResource($post), 200);
        return new PostResource($post);
    }

    public function show($id) {
        
        $post = Post::findOrFail($id);
        
        return new PostResource($post);
    }

    public function update() {

    }

    public function destroy() {

    }
}
