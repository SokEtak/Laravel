<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductOption\StoreProductOptionRequest;
use App\Http\Requests\ProductOption\UpdateProductOptionRequest;
use App\Models\Product;
use App\Models\ProductOptions;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductOptionsController extends Controller
{
    public function index(): Response
    {
        $productOptions = ProductOptions::with('product')->get();
        return Inertia::render('ProductOptions/Index', [
            'productOptions' => $productOptions,
        ]);
    }

    public function create(): Response
    {
        $products = Product::all(['id', 'name']);
        return Inertia::render('ProductOptions/Create', [
            'products' => $products,
        ]);
    }

    public function store(StoreProductOptionRequest $request): RedirectResponse
    {
        ProductOptions::create($request->validated());
        return redirect()->route('product-options.index')->with('success', 'Product Option created successfully!');
    }

    public function show(ProductOptions $productOption): Response
    {
        $productOption->load('product');
        return Inertia::render('ProductOptions/Show', [
            'productOption' => $productOption,
        ]);
    }

    public function edit(ProductOptions $productOption): Response
    {
        $products = Product::all(['id', 'name']);
        return Inertia::render('ProductOptions/Edit', [
            'productOption' => $productOption,
            'products' => $products,
        ]);
    }

    public function update(UpdateProductOptionRequest $request, ProductOptions $productOption): RedirectResponse
    {
        $productOption->update($request->validated());
        return redirect()->route('product-options.index')->with('success', 'Product Option updated successfully!');
    }

    public function destroy(ProductOptions $productOption): RedirectResponse
    {
        $productOption->delete();
        return redirect()->route('product-options.index')->with('success', 'Product Option deleted successfully!');
    }
}
