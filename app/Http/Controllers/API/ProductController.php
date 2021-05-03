<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_data = ProductResource::collection(request()->user()->products);
        return response()->json(['products' => $product_data, 'success' => 1],200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|max:20|min:3',
//                'image' => 'required|mimes:jpeg,png,jpg|max:512',
                'price' => 'required|integer|min:5|max:5000',
                'description' => 'required|min:10|max:1000',
            ]
        );
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors(), 'success' => 0],422);
        }
        $request_data = $request->only('name','price','description','image');
//        if ($request->file('image')){
//            $extension = $request->file('image')->extension();
//            $file_name = rand(10,1000).time().auth()->user()->id.'.'.$extension;
//            $request->file('image')->move('uploads/products',$file_name);
//            $request_data['image'] = $file_name;
//        }

        $request_data['user_id'] = $request->user()->id;
        $product = Product::create($request_data);
        $product_data = ProductResource::make($product);
        return response()->json(['product' => $product_data, 'message' => 'Product added successfully!' , 'success' => 1],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product_data = new ProductResource($product);
        return response()->json(['product' => $product_data , 'success' => 1],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->only('name','price','description'));
        $product_data = ProductResource::make($product);
        return response()->json(['product' => $product_data, 'message' => 'Product updated successfully!' , 'success' => 1],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        File::delete('uploads/products/'.$product->image);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully!' , 'success' => 1],200);
    }
}
