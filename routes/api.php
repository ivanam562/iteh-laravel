<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\AuthController;

use App\Http\Controllers\ProductRatingController;

Route::middleware('auth:sanctum')->get('/myprofile', function (Request $request) {
    return new UserResource($request->user());
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/register', [AuthController::class, 'register']); 
    Route::post('/logout', [AuthController::class, 'logout']);  
    Route::resource('users', UserController::class)->only(['destroy']);  
    Route::resource('users', UserController::class)->only(['index', 'show']); 
    Route::resource('users', UserController::class)->only(['update']);  

});


Route::post('/login', [AuthController::class, 'login']);

Route::resource('products', ProductController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::resource('productRating', ProductRatingController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::resource('providers', ProviderController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

