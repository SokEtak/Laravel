<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $products = Product::with(['discount', 'category', 'inventory'])->get();
      return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'discount_id' => 'required|exists:discounts,id',
            'SKU' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'inventory_id' => 'required|exists:inventories,id',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $product = Product::create($validator->validated());
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $product = Product::with(['discount', 'category', 'inventory'])->findOrFail($id);

        if(!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrfail($id);

        if(!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'discount_id' => 'required|exists:discounts,id',
            'SKU' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'inventory_id' => 'required|exists:inventories,id',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $product->update($validator->validated());

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if(!$product){
            return response()->json(["message" => "Product not found"], 404);
        }
        $product->delete();
        return response()->json(null, 204);
    }
}
