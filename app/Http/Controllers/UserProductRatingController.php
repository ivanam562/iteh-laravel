<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductRating;
use App\Http\Resources\ProductRatingCollection;

class UserProductRatingController extends Controller
{
    public function index($user_id)
    {
        $productRating = ProductRating::get()->where('user', $user_id);
        if (count($productRating) == 0)
            return response()->json('Data not found', 404);
        return new ProductRatingCollection($productRating);
    }

    public function myProductRating()
    {
        if(auth()->user()->isAdmin())
            return response()->json('You are not allowed to have product ratings.');  
        $productRating = ProductRating::get()->where('user', auth()->user()->id);
        if (count($productRating) == 0)
            return response()->json('Data not found', 404);
        return new ProductRatingCollection($productRating);

    }
}
