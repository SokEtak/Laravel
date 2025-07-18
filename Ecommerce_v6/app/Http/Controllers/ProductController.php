<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(): Response
    {
        $products = Product::all();
        return Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }

    public function create(): Response
    {
        $categories = Category::all(['id', 'name']);
        return Inertia::render('Products/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Create the product
        $product = Product::create($validated);

        // Associate product with its category
        ProductCategory::create([
            'product_id'  => $product->id,
            'category_id' => $validated['category_id'],
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully!');
    }


    public function show(Product $product): Response
    {
        $product->load('categories', 'productOptions', 'discounts', 'reviews');

        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }


    public function edit(Product $product): Response
    {
        $categories = Category::all(['id', 'name']);

        // Get array of category IDs from pivot table
        $productCategories = ProductCategory::where('product_id', $product->id)
            ->pluck('category_id')
            ->toArray();
//        dd($productCategories);
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'categories' => $categories,
            'productCategories' => $productCategories,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        if ($request->has('category_ids')) {
            $product->categories()->sync($request->category_ids);
        } else {
            $product->categories()->detach();
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
