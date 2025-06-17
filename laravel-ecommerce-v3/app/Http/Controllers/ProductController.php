<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function index()
    {
        $response = Http::get("http://127.0.0.1:8000/api/v1/products");
        $products = $response->json('data') ?? [];

        if ($response->successful()) {
            return view('products.index', compact('products'));
        }
        // Return a proper error view
        return response()->view('errors.500', ['message' => 'Failed to fetch products'], 500);
    }


    public function create()
    {
        $categories = Category::all();
        $discounts = Discount::all();
        $inventories = Inventory::all();
        return view('products.create', compact('categories', 'discounts', 'inventories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'discount_id' => 'nullable|exists:discounts,id',
            'SKU' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'inventory_id' => 'required|exists:inventories,id',
        ]);

        $response = Http::post("http://127.0.0.1:8000/api/v1/products", $validated);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Product created successfully');
        }

        return back()->withErrors('Failed to create product')->withInput();
    }

    public function show($id)
    {
        $response = Http::get("http://127.0.0.1:8000/api/v1/products/{$id}");

        if (!$response->successful()) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        $product = $response->json('data');

        return view('products.show', compact('product'));
    }


    public function edit($id)
    {
        $productResponse = Http::get("http://127.0.0.1:8000/api/v1/products/{$id}");

        if (!$productResponse->successful()) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        $product = $productResponse->json('data');
        $categories = Category::all();
        $discounts = Discount::all();
        $inventories = Inventory::all();

        return view('products.edit', compact('product', 'categories', 'discounts', 'inventories'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'discount_id' => 'nullable|exists:discounts,id',
            'SKU' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'inventory_id' => 'required|exists:inventories,id',
        ]);

        $response = Http::put("http://127.0.0.1:8000/api/v1/products/{$id}", $validated);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Product updated successfully');
        }

        return back()->withErrors('Failed to update product')->withInput();
    }

    public function destroy($id)
    {
        $response = Http::delete("http://127.0.0.1:8000/api/v1/products/{$id}");

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        }

        return redirect()->route('products.index')->with('error', 'Failed to delete product');
    }

}
