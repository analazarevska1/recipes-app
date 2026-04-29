<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', [HomeController::class, 'index'])->name('index');

// Recipes (public)
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post}/print', [PostController::class, 'print'])->name('posts.print');
Route::get('/posts/tag/{tag}', [PostController::class, 'tags'])->name('posts.tag');

// Public user profiles
Route::get('/users/{user}', [UserProfileController::class, 'show'])->name('users.show');

// Recipes (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/comment/{post}', [CommentController::class, 'save'])->name('comment.save');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

    Route::post('/like/{post}', [PostController::class, 'like'])->name('post.like');
    Route::post('/favorites/{post}', [PostController::class, 'favorite'])->name('post.favorite');
    Route::get('/favorites', [PostController::class, 'favPosts'])->name('favorite.index');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
