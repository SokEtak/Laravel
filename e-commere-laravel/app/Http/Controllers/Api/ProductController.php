<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'SKU' => 'required',
            'category_id' => 'required',
            'discount_id' => 'required',
            'price' => 'required|min:0',
            'product_category'=>'required'
        ]);
        $product = Product::create([
            'SKU' => $validated['SKU'],
            'category_id' => $validated['category_id'],
            'discount_id' => $validated['discount_id'],
            'price' => $validated['price'],
        ]);

        return response()->json($product,201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['product_category', 'product_detail'])->findOrFail($id);
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'SKU' => 'required',
            'category_id' => 'required',
            'discount_id' => 'required',
            'price' => 'required|min:0',
        ]);
        $product = Product::findOrFial($id);
        $product->update($validated);
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if(!$product) {
            return response()->json(["message" => "Product not found"], 404);
        }

        $product->delete();

        return response()->json(null, 204);
    }
}
