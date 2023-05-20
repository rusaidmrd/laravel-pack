<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;



// Public routes
Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');

Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show')
    ->whereNumber('post');


// Protected Routes
Route::middleware([
    'auth:sanctum'
])
    ->name('posts.')
    ->group(function () {
        Route::get('/my-posts', [PostController::class, 'myPost'])->name('by.user');

        Route::post('/posts', [PostController::class, 'store'])->name('store');

        Route::patch('/posts/{post}', [PostController::class, 'update'])->name('update');

        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('destroy');
    });
