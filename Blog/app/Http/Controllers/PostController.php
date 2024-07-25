<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {

    public function index() {
        // return response()->json(Post::with('user')->get());
        return PostResource::collection(Post::all());
    }
    
    public function store(PostRequest $request) {
        
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'tag_id' => $request->tag_id,
            'user_id' => auth()->user()->id,
        ]);

        return new PostResource($post);
    }

    public function show(Post $post) {
        
        return new PostResource($post);
    }
    
    public function update(UpdatePostRequest $request, Post $post) {

        if(auth()->user()->id !== $post->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'tag_id' => $request->tag_id,
            'user_id' => auth()->user()->id,
        ]);

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
