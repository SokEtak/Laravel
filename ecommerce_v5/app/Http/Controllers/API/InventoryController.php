<?php

namespace App\Http\Controllers\API;
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\orders\orders\inventories\StoreInventoryRequest;
use App\Http\Resources\InventoryResource;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        return InventoryResource::collection(Inventory::all());
    }

    public function store(StoreInventoryRequest $request)
    {
        $inventory = Inventory::create($request->validated());

        return response()->json([
            'message' => 'Inventory created successfully',
            'data' => new InventoryResource($inventory),
        ], 201);
    }

    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);

        return new InventoryResource($inventory);
    }

    public function update(StoreInventoryRequest $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $inventory->update($request->validated());

        return response()->json([
            'message' => 'Inventory updated successfully',
            'data' => new InventoryResource($inventory),
        ]);
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);

        $inventory->delete();

        return response()->json(['message' => 'Inventory deleted successfully']);
    }
}
