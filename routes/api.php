<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;



Route::get('/posts/{id}', [PostController::class, 'showApi']);
