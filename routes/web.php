<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/user', [UserController::class, 'index']);
Route::resource('users', UserController::class)->only(['index', 'show']); 
Route::resource('products', ProductController::class)->only(['index', 'show']);
