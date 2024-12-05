<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductRating;
use App\Models\Provider;
use App\Models\Product;
use App\Http\Resources\ProductRatingResource;
use App\Http\Resources\ProductRatingCollection;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ProductRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ProductRatingCollection(ProductRating::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_and_time' => 'required|date',
            'product' => 'required|numeric|gte:1|lte:5',
            'rating' => 'required|numeric|lte:5|gte:1',
            'note' => 'required|string|min:20',
            'providers' => 'required|numeric|gte:1|lte:10',
        ]);
        
        if ($validator->fails())
            return response()->json($validator->errors());
        
        $productRating = ProductRating::create([
            'date_and_time' => $request->date_and_time,
            'product' => $request->product,
            'rating' => $request->rating,
            'note' => $request->note,
            'providers' => $request->provider,
        ]);
        
        return response()->json(['message' => 'Product Rating is created successfully.', 'data' => new ProductRatingResource($productRating)]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRating $productRating)
    {
        return new ProductRatingResource($productRating);
    }

      /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductRating $productRating)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductRating $productRating)
    {
        $validator = Validator::make($request->all(), [
            'date_and_time' => 'required|date',
            'user' => 'required|numeric|digits_between:1,5',
            'product' => 'required|numeric|gte:1|lte:5',
            'rating' => 'required|numeric|lte:5|gte:1',
            'note' => 'required|string|min:20',
            'providers' => 'required|numeric|gte:1|lte:10',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors());

        if(auth()->user()->isAdmin())
            return response()->json('You are not authorized to update product ratings.');    

        if(auth()->user()->id != $productRating->user)
            return response()->json('You are not authorized to update someone elses product ratings.');     

        $productRating->date_and_time = $request->date_and_time;
        $productRating->user = auth()->user()->id;
        $productRating->product = $request->product;
        $productRating->rating = $request->rating;
        $productRating->note = $request->note;
        $productRating->providers = $request->provider;

        $productRating->save();

        return response()->json(['Product Rating is updated successfully.', new ProductRatingResource($productRating)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductRating $productRating)
    {
        if(auth()->user()->isAdmin())
            return response()->json('You are not authorized to delete Product Ratings.');    

        if(auth()->user()->id != $productRating->user)
            return response()->json('You are not authorized to delete someone elses Product Ratings.');

        $productRating->delete();

        return response()->json('Product Rating is deleted successfully.');
    }
}