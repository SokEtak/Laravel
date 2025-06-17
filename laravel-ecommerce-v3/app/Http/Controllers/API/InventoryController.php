<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryResource;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return InventoryResource::collection(Inventory::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1|max:99',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $inventory = Inventory::create($validator->validated());
        return new InventoryResource($inventory);
    }


    /**
     * Display the specified resource.
     */
    public function show($id )
    {
        $inventory = Inventory::findOrFail($id);

        if(!$inventory) {
            return response()->json(["message" => "Product not found"], 404);
        }

        return new InventoryResource($inventory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $inventory =  Inventory::findOrFail($id);

        if(!$inventory) {
            return response()->json(["message" => "Product not found"], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1|max:99',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $inventory -> update($validator->validated());
        return new InventoryResource($inventory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inventory =  Inventory::findOrFail($id);

        if (!$inventory) {
            return response()->json(['message' => 'Inventory not found'], 404);
        }
        $inventory -> delete();
        return response()->json(null, 204);
    }
}
