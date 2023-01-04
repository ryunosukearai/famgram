<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\PostsController;
use App\Http\Controllers\admin\CategoriesController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::post('/category', [CategoryController::class, 'store'])->name('category'); // add categories without admin !!temporary
// Route::get('/admin', [UsersController::class, 'index']);

Route::group(['prefix'=>'admin', 'as'=> 'admin.'], function(){
    // USERS
    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');
    Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate');

    //posts
    Route::get('/posts', [PostsController::class, 'index'])->name('posts');
    Route::delete('/posts/{id}/unvisible', [PostsController::class, 'unvisible'])->name('posts.unvisible');
    Route::patch('/posts/{id}/visible', [PostsController::class, 'visible'])->name('posts.visible');

    //Categories
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
    Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{id}/delete', [CategoriesController::class, 'destroy'])->name('categories.destroy');
});

Route::group(['middleware'=>'auth'],function(){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
    Route::resource('/post', PostController::class);
    Route::resource('/comment', CommentController::class);
    Route::resource('/profile', ProfileController::class);
    Route::resource('/like', LikeController::class);
    Route::resource('/follow', FollowController::class);
    // Route::resource('/users', UsersController::class);


    //Route::resource('/category', CategoryController::class);

    // Route::group(['prefix' => 'post', 'as' => 'post.'], function(){
    //     Route::get('/create', [PostController::class, 'create'])->name('create');
    //     Route::post('/store', [PostController::class, 'store'])->name('store');
    // });

    // Route::group(['prefix' => 'category', 'as' => 'category.'], function(){
    //     Route::post('/store', [CategoryController::class, 'store'])->name('store');
    // });




});


