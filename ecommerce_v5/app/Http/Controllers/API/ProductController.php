<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\products\StoreProductRequest; // Assuming this is also used for API validation
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Inventory; // Added Inventory model for handling its deletion
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB; // Import DB facade for transactions
use Throwable; // Import Throwable for catching all exceptions
use Illuminate\Database\Eloquent\ModelNotFoundException; // Specific exception for findOrFail

class ProductController extends Controller
{
   
    public function index(): AnonymousResourceCollection|JsonResponse
    {
        try {
            $products = Product::with(['discount', 'category', 'inventory'])->get();
            // Optional: For large datasets, consider adding pagination:
            // $products = Product::with(['discount', 'category', 'inventory'])->paginate(15);

            return ProductResource::collection($products);
        } catch (Throwable $e) {
            // Log the error for debugging
            \Log::error("API Error fetching products: " . $e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'An error occurred while fetching products.'], 500); // 500 Internal Server Error
        }
    }

   
    public function store(StoreProductRequest $request): JsonResponse
    {
        DB::beginTransaction(); // Start a database transaction

        try {
            $validated = $request->validated();

            $product = Product::create([
                'product_name' => $validated['product_name'],
                'product_description' => $validated['product_description'] ?? null, // Ensure these are nullable if not always present
                'SKU' => $validated['SKU'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'],
                'discount_id' => $validated['discount_id'] ?? null,
            ]);

            // Assuming inventory creation is part of product creation via API
            if (isset($validated['inventory_quantity']) && $validated['inventory_quantity'] !== null) {
                $inventory = Inventory::create([
                    'quantity' => $validated['inventory_quantity'],
                    'product_id' => $product->id,
                ]);
                $product->update(['inventory_id' => $inventory->id]);
            }

            DB::commit(); // Commit the transaction if successful

            // Load relationships for the resource before returning
            $product->loadMissing(['discount', 'category', 'inventory']);

            return response()->json([
                'message' => 'Product created successfully',
                'data' => new ProductResource($product)
            ], 201); // HTTP 201 Created

        } catch (Throwable $e) {
            DB::rollBack(); // Rollback the transaction on error
            \Log::error("API Error creating product: " . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            return response()->json(['message' => 'Failed to create product. An internal server error occurred.'], 500); // 500 Internal Server Error
        }
    }

    public function show(Product $product): ProductResource|JsonResponse
    {
        try {
            // Use loadMissing() to ensure relationships are loaded for the resource.
            $product->loadMissing(['discount', 'category', 'inventory']);
            return new ProductResource($product);
        } catch (ModelNotFoundException $e) { // Catch specifically if product not found
            \Log::warning("API Product not found: " . $product->id, ['exception' => $e]);
            return response()->json(['message' => 'Product not found.'], 404); // 404 Not Found
        } catch (Throwable $e) {
            \Log::error("API Error showing product ID " . $product->id . ": " . $e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'An error occurred while fetching the product.'], 500); // 500 Internal Server Error
        }
    }

    public function update(StoreProductRequest $request, Product $product): JsonResponse
    {
        DB::beginTransaction(); // Start a database transaction

        try {
            $validated = $request->validated();

            $product->update([
                'product_name' => $validated['product_name'],
                'product_description' => $validated['product_description'] ?? $product->product_description, // Retain existing if not provided
                'SKU' => $validated['SKU'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'],
                'discount_id' => $validated['discount_id'] ?? null,
            ]);

            // Handle inventory quantity update logic (similar to web controller)
            if (isset($validated['inventory_quantity'])) {
                if ($product->inventory) {
                    $product->inventory->update([
                        'quantity' => $validated['inventory_quantity'],
                    ]);
                } else {
                    // Create new inventory if it didn't exist for the product
                    $inventory = Inventory::create([
                        'quantity' => $validated['inventory_quantity'],
                        'product_id' => $product->id,
                    ]);
                    $product->update(['inventory_id' => $inventory->id]);
                }
            }
            // Optional: If inventory_quantity is explicitly null and it exists, you might want to delete it
            // else if ($product->inventory && array_key_exists('inventory_quantity', $validated) && $validated['inventory_quantity'] === null) {
            //     $product->inventory->delete();
            //     $product->update(['inventory_id' => null]);
            // }


            DB::commit(); // Commit the transaction if successful

            // Load relationships for the resource before returning
            $product->loadMissing(['discount', 'category', 'inventory']);

            return response()->json([
                'message' => 'Product updated successfully',
                'data' => new ProductResource($product)
            ]);

        } catch (Throwable $e) {
            DB::rollBack(); // Rollback the transaction on error
            \Log::error("API Error updating product ID " . $product->id . ": " . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            return response()->json(['message' => 'Failed to update product. An internal server error occurred.'], 500); // 500 Internal Server Error
        }
    }

    public function destroy(Product $product): JsonResponse
    {
        DB::beginTransaction(); // Start a database transaction

        try {
            // Get inventory ID before potentially deleting the product or its relationships
            $inventoryId = $product->inventory_id;

            $product->delete(); // This should trigger cascading deletes if set up in DB or model events

            // Manually delete inventory if it exists and cascading isn't handled automatically
            if ($inventoryId) {
                $inventory = Inventory::find($inventoryId);
                if ($inventory) {
                    $inventory->delete();
                }
            }

            DB::commit(); // Commit the transaction if successful

            return response()->json([
                'message' => 'Product deleted successfully'
            ], 204); // HTTP 204 No Content - success with no content to return

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            \Log::warning("API Product not found for deletion: " . $product->id, ['exception' => $e]);
            return response()->json(['message' => 'Product not found.'], 404); // 404 Not Found
        } catch (Throwable $e) {
            DB::rollBack(); // Rollback the transaction on error
            \Log::error("API Error deleting product ID " . $product->id . ": " . $e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'Failed to delete product. An internal server error occurred.'], 500); // 500 Internal Server Error
        }
    }
}