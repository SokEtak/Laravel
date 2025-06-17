<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\products\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        // Eager load relationships to prevent N+1 query problem if ProductResource
        // accesses them for each product in the collection.
        $products = Product::with(['discount', 'category', 'inventory'])->get();

        // Optional: For large datasets, consider adding pagination:
        // $products = Product::with(['discount', 'category', 'inventory'])->paginate(15);

        return ProductResource::collection($products);
    }


    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product)
        ], 201); // HTTP 201 Created
    }


    public function show(Product $product): ProductResource
    {
        // Use loadMissing() to ensure relationships are loaded.
        $product->loadMissing(['discount', 'category', 'inventory']);

        return new ProductResource($product);
    }


    public function update(StoreProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ], 204); // HTTP 204 No Content
    }
}
