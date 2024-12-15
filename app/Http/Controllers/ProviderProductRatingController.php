<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductRating;
use App\Http\Resources\ProductRatingCollection;

class ProviderProductRatingController extends Controller
{
    public function index($provider_id)
    {
        $productrating = ProductRating::get()->where('provider', $provider_id);
        if (count($productrating) == 0)
            return response()->json('Data not found', 404);
        return new ProductRatingCollection($productrating);
    }
}
