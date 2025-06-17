<?php

namespace App\Http\Controllers;

use App\Http\Requests\products\StoreProductRequest;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->get('category');
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
                'product_id' => $product->id,
            ]);

            $product->update(['inventory_id' => $inventory->id]);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::with(['category', 'discount', 'inventory'])->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::with('inventory')->findOrFail($id);

        return view('products.edit', [
            'product' => $product,
            'categories' => Category::all(),
            'discounts' => Discount::all(),
        ]);
    }

    public function update(StoreProductRequest $request, $id)
    {
        $validated = $request->validated();
        $product = Product::findOrFail($id);

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
                $inventory = Inventory::create([
                    'quantity' => $validated['inventory_quantity'],
                    'product_id' => $product->id,
                ]);
                $product->update(['inventory_id' => $inventory->id]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $inventoryId = $product->inventory_id;

        $product->delete();

        if ($inventoryId) {

            $inventory = Inventory::find($inventoryId);
            if ($inventory) {
                $inventory->delete();
            }
        }
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
