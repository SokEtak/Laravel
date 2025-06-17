<?php

namespace App\Http\Controllers;

use App\Http\Requests\products\StoreProductRequest;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB facade for transactions
use Throwable; // Import Throwable for catching all exceptions

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->get('category');
        //filter product by category if provided
        $products = Product::when($categoryId, function ($query, $categoryId) {
            return $query->where('category_id', $categoryId);
        })->get();

        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        return view('products.create', [
            'categories' => Category::all(),
            'discounts' => Discount::all(),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        // Use a database transaction to ensure atomicity
        // If anything fails, all changes are rolled back.
        DB::beginTransaction();

        try {
            $validated = $request->validated();

            $product = Product::create([
                'product_name' => $validated['product_name'],
                'product_description' => $validated['product_description'],
                'SKU' => $validated['SKU'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'],
                'discount_id' => $validated['discount_id'] ?? null,
            ]);

            if (!empty($validated['inventory_quantity'])) {
                $inventory = Inventory::create([
                    'quantity' => $validated['inventory_quantity'],
                    'product_id' => $product->id, // Link inventory to the newly created product
                ]);

                // Update the product with the new inventory_id
                $product->update(['inventory_id' => $inventory->id]);
            }

            DB::commit(); // Commit the transaction if everything is successful
            return redirect()->route('products.index')->with('success', 'Product created successfully.');

        } catch (Throwable $e) { // Catch any kind of exception
            DB::rollBack(); // Rollback the transaction on error
            // Log the error for debugging
            \Log::error("Error creating product: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Failed to create product. Please try again.');
        }
    }

    public function show($id)
    {
        try {
            $product = Product::with(['category', 'discount', 'inventory'])->findOrFail($id);
            return view('products.show', compact('product'));
        } catch (Throwable $e) {
            \Log::error("Error showing product ID " . $id . ": " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('products.index')->with('error', 'Product not found or an error occurred.');
        }
    }

    public function edit($id)
    {
        try {
            $product = Product::with('inventory')->findOrFail($id);
            return view('products.edit', [
                'product' => $product,
                'categories' => Category::all(),
                'discounts' => Discount::all(),
            ]);
        } catch (Throwable $e) {
            \Log::error("Error editing product ID " . $id . ": " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('products.index')->with('error', 'Product not found or an error occurred.');
        }
    }

    public function update(StoreProductRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $product = Product::findOrFail($id); // Find the product within the transaction

            $product->update([
                'product_name' => $validated['product_name'],
                'product_description' => $validated['product_description'],
                'SKU' => $validated['SKU'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'],
                'discount_id' => $validated['discount_id'] ?? null,
            ]);

            // Handle inventory quantity update
            if (isset($validated['inventory_quantity'])) {
                if ($product->inventory) {
                    $product->inventory->update([
                        'quantity' => $validated['inventory_quantity'],
                    ]);
                } else {
                    // Create new inventory if it didn't exist
                    $inventory = Inventory::create([
                        'quantity' => $validated['inventory_quantity'],
                        'product_id' => $product->id, // Link new inventory to product
                    ]);
                    $product->update(['inventory_id' => $inventory->id]);
                }
            } else {
                // If inventory_quantity is not set in validated data but product has inventory,
                // consider detaching/deleting inventory if that's your business logic
                // For now, we'll leave it as is if quantity is not provided.
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product updated successfully.');

        } catch (Throwable $e) {
            DB::rollBack();
            \Log::error("Error updating product ID " . $id . ": " . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Failed to update product. Please try again.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction(); // Start a transaction

        try {
            $product = Product::findOrFail($id);

            // Get inventory ID before deleting the product
            $inventoryId = $product->inventory_id;

            // Delete the product
            $product->delete();

            // If an inventory was linked, try to delete it
            if ($inventoryId) {
                $inventory = Inventory::find($inventoryId); // Use find, as findOrFail would throw an error if not found
                if ($inventory) {
                    $inventory->delete();
                }
            }

            DB::commit(); // Commit if all deletions are successful
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');

        } catch (Throwable $e) {
            DB::rollBack(); // Rollback if any error occurs during deletion
            \Log::error("Error deleting product ID " . $id . ": " . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Failed to delete product. Please try again.');
        }
    }
}