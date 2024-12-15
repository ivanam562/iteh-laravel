<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProductRating;
use App\Models\Provider;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ProductCollection(Product::all());
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
    public function store(Request $request){
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:150|unique:products',
    ]);

    if ($validator->fails())
        return response()->json($validator->errors());

    if(auth()->user()->isUser())
        return response()->json('You are not authorized to create new products.');  

    $product = Product::create([
        'name' => $request->name,
    ]);

    return response()->json(['Product is created successfully.', new ProductResource($product)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
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
    
    public function update(Request $request, $id){
    $product = Product::find($id);
    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:150|unique:products,name,' . $product->id,
    ]);

    if ($validator->fails())
        return response()->json($validator->errors());

    if (auth()->user()->isUser())
        return response()->json('You are not authorized to update products.');

    $product->name = $request->name;
    $product->save();

    return response()->json(['message' => 'Product is updated successfully.', 'product' => new ProductResource($product)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (auth()->user()->isUser()) {
            return response()->json('You are not authorized to delete products.');
        }
    
        $prodrat = ProductRating::where('product', $product->id)->get();
        if ($prodrat->count() > 0) {
            return response()->json('You cannot delete products that have product ratings.');
        }
        $product->delete();
    
        return response()->json('Product is deleted successfully.');
    }

    public function search(Request $request)
    {
        Log::info('Pretraga započeta', ['request' => $request->all()]);

        $query = Product::query();
    
        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        $products = $query->get();
    
        return response()->json($products);
    }
}
