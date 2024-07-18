<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth.token'])->group(function () {
    
    // Blog Routes
    Route::get('blogs', [BlogController::class, 'index']);
    Route::post('blogs', [BlogController::class, 'store']);
    Route::get('blogs/{blog}', [BlogController::class, 'show']);
    Route::put('blogs/{blog}', [BlogController::class, 'update']);
    Route::delete('blogs/{blog}', [BlogController::class, 'destroy']);


    // Post Routes
    Route::post('blogs/{blog}/posts', [PostController::class, 'store']);
    Route::get('blogs/{blog}/posts', [PostController::class, 'index']);
    Route::get('blogs/{blog}/posts/{post}', [PostController::class, 'show']);
    Route::put('blogs/{blog}/posts/{post}', [PostController::class, 'update']);
    Route::delete('blogs/{blog}/posts/{post}', [PostController::class, 'destroy']);

    // Interaction Routes
    Route::post('posts/{post}/like', [LikeController::class, 'store']);
    Route::post('posts/{post}/comment', [CommentController::class, 'store']);
});

// Route::get('/', function () {
//     return view('welcome');
// });
