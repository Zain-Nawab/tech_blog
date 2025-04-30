<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\PostController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;



Route::get('/', [BlogController::class, "index"])->name('blog.index');

Route::get("/post/{id}", [BlogController::class, 'single'])->name('blog.single');


Route::get("/login", [AuthController::class, 'loginForm'])->name("loginForm");
Route::post("/login", [AuthController::class, 'login'])->name("login");
Route::post('/logout', [AuthController::class, 'logout'])->name("logout");

Route::get("/signup", [AuthController::class, 'signupForm'])->name("signupForm");
Route::post("/register", [AuthController::class, 'register'])->name("register");

// Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard.index")->middleware('auth');

Route::middleware(['auth'])->prefix('/dashboard')->group( function() {

    //dashboard routes
    Route::get('/', [DashboardController::class, 'index'])->name("dashboard.index");
    Route::get('/settings', [DashboardController::class, 'settings'])->name("dashboard.settings");

    // post route

    Route::get('/posts', [PostController::class, 'index'])->name('post.index');
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');

    // post edit and delte 
    Route::get('/post/delete/{id}', [PostController::class, 'delete'])->name('post.delete');
    Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::post('/post/update/{id}', [PostController::class, 'update'])->name('post.update');

    Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');
    
});

// category routes only for admin
Route::middleware(['auth', 'is_admin'])->prefix('/dashboard')->group( function() {

    //Route::resource('cat', CategoryController::class);
    Route::get("/cats", [CategoryController::class, 'index'])->name('cats.index');
    Route::get("/cat/create", [CategoryController::class, 'create'])->name('cat.create');
    Route::post("/cat/store", [CategoryController::class, 'store'])->name('cat.store');
    Route::get("/cat/delete/{id}", [CategoryController::class, 'destroy'])->name('cat.delete');
    Route::get("/cat/edit/{id}", [CategoryController::class, 'edit'])->name('cat.edit');
});



Route::middleware('auth')->post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');



// Route::get('/', function () {
//     return view('welcome');
// });
