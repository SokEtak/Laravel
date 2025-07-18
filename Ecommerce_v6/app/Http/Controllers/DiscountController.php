<?php

namespace App\Http\Controllers;

use App\Http\Requests\Discount\StoreDiscountRequest;
use App\Http\Requests\Discount\UpdateDiscountRequest;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class DiscountController extends Controller
{
    public function index(): Response
    {
        $discounts = Discount::with('product')->get(); // Load product relationship for display
        return Inertia::render('Discounts/Index', [
            'discounts' => $discounts,
        ]);
    }

    public function create(): Response
    {
        $products = Product::all(['id', 'name']);
        return Inertia::render('Discounts/Create', [
            'products' => $products,
        ]);
    }

    public function store(StoreDiscountRequest $request): RedirectResponse
    {
        Discount::create($request->validated());
        return redirect()->route('discounts.index')->with('success', 'Discount created successfully!');
    }

    public function show(Discount $discount): Response
    {
        $discount->load('product');
        return Inertia::render('Discounts/Show', [
            'discount' => $discount,
        ]);
    }

    public function edit(Discount $discount): Response
    {
        $products = Product::all(['id', 'name']);
        return Inertia::render('Discounts/Edit', [
            'discount' => $discount,
            'products' => $products,
        ]);
    }

    public function update(UpdateDiscountRequest $request, Discount $discount): RedirectResponse
    {
        $discount->update($request->validated());
        return redirect()->route('discounts.index')->with('success', 'Discount updated successfully!');
    }

    public function destroy(Discount $discount): RedirectResponse
    {
        $discount->delete();
        return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully!');
    }
}
