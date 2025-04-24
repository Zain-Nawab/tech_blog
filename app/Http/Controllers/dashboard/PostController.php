<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    
    public function index(){

        $posts = Auth::user()->posts;

        // dd($posts);

        // $user_id = Auth::user()->id;

        // // dd($user_id);

        // $posts = Post::where('user_id',$user_id)->get();

        return view('dashboard.posts.index', ['posts' => $posts]);
    }

    public function create(){
        return view('dashboard.posts.create');
    }

    public function store(Request $request){

        // validate data
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'excerpt' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        // upload image
        $path = $request->file('image')->store('uploads', 'public');

        // store data in db 
        Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::user()->id,
            'excerpt' => $request->input('excerpt'),
            'photo_path' => $path,
        ]);

        return redirect()->route('post.index')->with('success', 'Post created successfully!');
    }

    public function delete($id){

        $post = Post::findOrfail($id);

        // delete img 
        if ($post->photo_path && Storage::disk('public')->exists($post->photo_path)){
            Storage::disk('public')->delete($post->photo_path);
        }
        $post->delete();
        return redirect()->route("post.index")->with('delete', "Post deleted Successfully");
    }

    public function edit(Request $request, $id){
        $post = Post::findOrfail($id);
        return view('blog.edit', ['post' => $post]);
    }

    public function update(Request $request, $id){
        $post = Post::findOrdail($id);

        // validate data
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5048',
        ]);


        // save data in db 
        $post->title = $request->input('title');
        $post->content = $request->input('content');

        
        

        // delte old image
        if ($request->hasFile('image')){
            if ($post->photo_path && Storage::disk('public')->exists($post->photo_path)){
                Storage::disk('public')->delete($post->photo_path);
            }
        }

        // upload image new img
        $path = $request->file('image')->store('uploads', 'public');
        $post->photo_path = $path;

        $post->save();
        
        return redirect()->route("post.index")->with('update', 'Successfully Updated');
    }
}
