<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function index()
    {
        $response = Http::get('http://127.0.0.1:8000/api/v1/inventories');

        if ($response->successful()) {
            $inventories = $response->json('data');
            return view('inventories.index', compact('inventories'));
        }

        return abort(500, 'Error fetching inventory data.');
    }

    public function create()
    {
        return view('inventories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1|max:99',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $response = Http::post('http://127.0.0.1:8000/api/v1/inventories', $validator->validated());

        if ($response->successful()) {
            return redirect()->route('inventories.index')->with('success', 'Inventory created successfully.');
        }

        return back()->with('error', 'Failed to create inventory.');
    }

    public function show($id)
    {
        $response = Http::get("http://127.0.0.1:8000/api/v1/inventories/{$id}");

        if ($response->successful()) {
            $inventory = $response->json('data');
//            dd($inventory);
            return view('inventories.show', compact('inventory'));
        }

        return abort(404);
    }

    public function edit($id)
    {
        $response = Http::get("http://127.0.0.1:8000/api/v1/inventories/{$id}");

        if ($response->successful()) {
            $inventory = $response->json('data');
            return view('inventories.edit', compact('inventory'));
        }

        return abort(404);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1|max:99',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $response = Http::put("http://127.0.0.1:8000/api/v1/inventories/{$id}", $validator->validated());

        if ($response->successful()) {
            return redirect()->route('inventories.index')->with('success', 'Inventory updated successfully.');
        }

        return back()->with('error', 'Failed to update inventory.');
    }

    public function destroy($id)
    {
        $response = Http::delete("http://127.0.0.1:8000/api/v1/inventories/{$id}");

        if ($response->successful()) {
            return redirect()->route('inventories.index')->with('success', 'Inventory deleted successfully.');
        }

        return back()->with('error', 'Failed to delete inventory.');
    }
}
