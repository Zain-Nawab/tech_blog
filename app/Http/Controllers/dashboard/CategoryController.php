<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cat = Category::all();
        return view('dashboard.categories.index', ['cats' => $cat]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required | string '
        ]);

        // create category
        Category::create([
            'name' => $request->input('name')
        ]);

        return redirect()->route('cats.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $cat = Category::findOrfail($id);
        
        // delete img 
        if($cat->photo_path && Storage::disk('public')->exists($cat->photo_path)){
            Storage::disk('public')->delete($cat->photo_path);
        }
        $cat->delete();

        return redirect()->route("cats.index")->with('delete', "Post deleted Successfully");
    }
}
