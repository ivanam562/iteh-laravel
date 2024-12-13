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
   
     //prikaz korisnika je moguc za user-a ili za admin-a
    Route::resource('users', UserController::class)->only(['index', 'show']); 
    //azuriranje i brisanje je moguce samo za admina
    Route::resource('users', UserController::class)->only(['update']);  
    Route::resource('users', UserController::class)->only(['destroy']);  
    //samo user moze da doda, azurira ili brise proizod
    Route::resource('products', ProductController::class)->only(['store', 'update', 'destroy']); 
    //samo user moze da doda, azurira ili brise proizod
    Route::resource('providers', ProviderController::class)->only(['store', 'update', 'destroy']);  

});


Route::post('/login', [AuthController::class, 'login']);
//svi mogu da pregledaju proizvode, cak iako nisu loginovani
Route::resource('products', ProductController::class)->only(['index', 'show']);
//svi mogu da pregledaju providere, cak iako nisu loginovani
Route::resource('providers', ProviderController::class)->only(['index', 'show']);

Route::resource('productRating', ProductRatingController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

