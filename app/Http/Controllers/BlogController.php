<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request ){



        $category_name = $request->query('category');        
         
         if($category_name) {
             $category = Category::where('name', $category_name)->first();
             $posts = Post::where("category_id", $category->id)->latest()->get();
 
         } else {
             $posts = Post::latest()->get();
         }
        
        //$posts = Post::all();

        return view("blog.index", ['posts' => $posts, 'category' => $category_name]);
    }



    public function single($id){

        $post = Post::findOrfail($id);
        return view("blog.single", ['post' => $post]);
    }
}
