<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProductRatingController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('products', ProductController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::resource('productRating', ProductRatingController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::resource('providers', ProviderController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

