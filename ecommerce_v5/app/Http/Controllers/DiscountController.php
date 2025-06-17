<?php

namespace App\Http\Controllers;

use App\Http\Requests\discounts\StoreDiscountRequest;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::all();
        return view('discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('discounts.create');
    }

    public function store(StoreDiscountRequest $request)
    {
        Discount::create($request->validated());
        return redirect()->route('discounts.index')->with('success', 'Discount created successfully.');
    }

    public function show($id)
    {
        $discount = Discount::findOrFail($id);
        return view('discounts.show', compact('discount'));
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        return view('discounts.edit', compact('discount'));
    }

    public function update(StoreDiscountRequest $request, $id)
    {
        $discount = Discount::findOrFail($id);
        $discount->update($request->validated());
        return redirect()->route('discounts.index')->with('success', 'Discount updated successfully.');
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully.');
    }
}
