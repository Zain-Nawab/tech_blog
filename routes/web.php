<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\PostController;
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
    
});

// category routes only for admin
Route::middleware(['auth'])->prefix('/dashboard')->group( function() {
    Route::get("/cats", [CategoryController::class, 'index'])->name('cats.index');
    Route::get("/cat/create", [CategoryController::class, 'create'])->name('cat.create');
    Route::post("/cat/store", [CategoryController::class, 'store'])->name('cat.store');
});


// Route::get('/', function () {
//     return view('welcome');
// });
