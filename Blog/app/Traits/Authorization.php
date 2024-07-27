<?php

namespace App\Traits;

trait Authorization {

    public function authorizeUpdate($request, $post) {
        // dd($request->user()->cannot('update', $post));
        if($request->user()->cannot('update', $post)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }

    public function authorizeDestroy($post) {
        // dd(auth()->user()->id !== $post->user_id);
        if(auth()->user()->id !== $post->user_id) {
            // dd('oi');
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}