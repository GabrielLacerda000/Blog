<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\Authorization;

class PostController extends Controller {
    use Authorization;

    public function index() {
        
        return PostResource::collection(Post::all());
    }
    
    public function store(PostRequest $request) {
        
        $post = auth()->user()->post()->create($request->validated());
        
        return new PostResource($post);
    }

    public function show(Post $post) {
        
        return new PostResource($post);
    }
    
    public function update(UpdatePostRequest $request, Post $post) {

        if($request->user()->cannot('update', $post)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $post->update($data);

        return new PostResource($post);
    }

    public function destroy(Post $post) {

        if(auth()->user()->id !== $post->user_id) {
        
            return response()->json(['error' => 'Unauthorized'], 403);
        }
      
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }

    
}
