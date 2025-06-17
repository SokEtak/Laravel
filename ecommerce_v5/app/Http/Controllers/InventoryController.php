<?php

namespace App\Http\Controllers;

use App\Http\Requests\inventories\StoreInventoryRequest;
use App\Models\Inventory;
use App\Models\Product;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();

        return view('inventories.index', compact('inventories'));
    }

//    public function create()
//    {
//        $products = Product::all();
//
//        return view('inventories.create', compact('products'));
//    }

//    public function store(StoreInventoryRequest $request)
//    {
//        // Create the inventory with validated data
//        $inventory = Inventory::create($request->validated());
//
//        // Find the related product
//        $product = Product::findOrFail($inventory->product_id);
//
//        // Update only the inventory_id field of the product
//        $product->update([
//            'inventory_id' => $inventory->id,
//        ]);
//
//        // Redirect with success message
//        return redirect()->route('inventories.index')->with('success', 'Inventory created successfully.');
//    }


    public function show($id)
    {
        $inventory = Inventory::with('product')->findOrFail($id);

        return view('inventories.show', compact('inventory'));
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);

        $products = Product::all();

        return view('inventories.edit', compact('inventory', 'products'));
    }

    public function update(StoreInventoryRequest $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $inventory->update($request->validated());

        return redirect()->route('inventories.index')->with('success', 'Inventory updated successfully.');
    }

//    public function destroy($id)
//    {
//        $inventory = Inventory::findOrFail($id);
//
//        $inventory->delete();
//
//        return redirect()->route('inventories.index')->with('success', 'Inventory deleted successfully.');
//    }
}
