<?php

namespace App\Http\Controllers\API;
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\inventories\StoreInventoryRequest;
use App\Http\Resources\InventoryResource;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
            return InventoryResource::collection(Inventory::all());
    }

//    public function store(StoreInventoryRequest $request)
//    {
//            $inventory = Inventory::create($request->validated());
//
//            return response()->json([
//                'message' => 'Inventory created successfully',
//                'data' => new InventoryResource($inventory),
//            ], 201);
//    }

    public function show($id)
    {
        try {
            $inventory = Inventory::findOrFail($id);
            return new InventoryResource($inventory);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Inventory not found'], 404);
        }
    }

    public function update(StoreInventoryRequest $request, $id)
    {
        try {
            $inventory = Inventory::findOrFail($id);
            $inventory->update($request->validated());

            return response()->json([
                'message' => 'Inventory updated successfully',
                'data' => new InventoryResource($inventory),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating inventory'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $inventory = Inventory::findOrFail($id);
            $inventory->delete();

            return response()->json(['message' => 'Inventory deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting inventory'], 500);
        }
    }
}
