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
        try {
            $discount = Discount::findOrFail($id);
            return view('discounts.show', compact('discount'));
        } catch (\Exception $e) {
            return redirect()->route('discounts.index')->with('error', 'Discount not found.');
        }
    }

    public function edit($id)
    {
        try {
            $discount = Discount::findOrFail($id);
            return view('discounts.edit', compact('discount'));
        } catch (\Exception $e) {
            return redirect()->route('discounts.index')->with('error', 'Discount not found.');
        }
    }

    public function update(StoreDiscountRequest $request, $id)
    {
        try {
            $discount = Discount::findOrFail($id);
            $discount->update($request->validated());
            return redirect()->route('discounts.index')->with('success', 'Discount updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('discounts.index')->with('error', 'Error updating discount.');
        }
    }

    public function destroy($id)
    {
        try {
            $discount = Discount::findOrFail($id);
            $discount->delete();
            return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('discounts.index')->with('error', 'Error deleting discount.');
        }
    }
}
