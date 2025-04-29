<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request) {

    

        $request->validate([
            'comment' => 'required',
        ]);

        $user_id = Auth::user()->id;
        $post_id = $request->input('post_id');
        $comment = $request->input('comment');


       //filter comment 
       if($this->filtercomment($comment == true)) {
        return back()->with('error', "Don't use abusive words");
       }


        // store comment
        Comment::create([
            'user_id' => $user_id,
            'post_id' => $post_id,
            'comment' => $comment,
        ]);

        //
        return back()->with('success', "Comment Send Successfully");
    }


    // cmomment filter hlper function

    protected function filtercomment($text){
        return str_contains($text, ' hi ');
    }
}
