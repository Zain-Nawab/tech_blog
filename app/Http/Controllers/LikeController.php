<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $user = auth()->user();
    
        $like = $post->likes()->where('user_id', $user->id)->first();
    
        if ($like) {
            $like->delete();
            return back();
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            return back();
        }
    }
}
