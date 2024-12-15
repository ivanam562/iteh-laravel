<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\AuthController;

use App\Http\Controllers\ProductRatingController;

use App\Http\Controllers\UserProductRatingController;
use App\Http\Controllers\ProviderProductRatingController;
use App\Http\Controllers\ProductProductRatingController;

Route::middleware('auth:sanctum')->get('/myprofile', function (Request $request) {
    return new UserResource($request->user());
});

Route::group(['middleware' => ['auth:sanctum']], function () {
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
    //samo user moze da doda, azurira ili brise rejting proizoda
    Route::resource('productRating', ProductRatingController::class)->only(['store', 'update', 'destroy']); 

    Route::get('/myProductRating', [UserProductRatingController::class, 'myProductRating']); 

});
Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']); 

//svi mogu da pregledaju proizvode, cak iako nisu loginovani
Route::resource('products', ProductController::class)->only(['index', 'show']);
//svi mogu da pregledaju providere, cak iako nisu loginovani
Route::resource('providers', ProviderController::class)->only(['index', 'show']);
//svi mogu da pregledaju rejtinge, cak iako nisu loginovani
Route::resource('productRating', ProductRatingController::class)->only(['index', 'show']);


Route::get('/users/{id}/productRating', [UserProductRatingController::class, 'index']);

Route::get('/providers/{id}/productRating', [ProviderProductRatingController::class, 'index']);

Route::get('/products/{id}/productRating', [ProductProductRatingController::class, 'index']);
