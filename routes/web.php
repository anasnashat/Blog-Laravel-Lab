<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/posts');

//Route::resource('posts', PostController::class)->middleware('auth')->except(['index', 'show']);


Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)->except('show','edit');
    Route::get('posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
    Route::get('posts/{post:slug}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::get('my-posts', [PostController::class, 'myPosts'])->name('posts.myPosts');
    Route::patch('/posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::resource('comments', CommentController::class);
});

// Route::get('api/posts/{id}', [PostController::class, 'showApi']);

/**
 * @return void
 */
function extracted(): void
{
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__ . '/auth.php';
}

extracted();
