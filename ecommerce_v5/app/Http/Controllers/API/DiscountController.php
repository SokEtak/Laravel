<?php

namespace App\Http\Controllers\API;
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\orders\orders\discounts\StoreDiscountRequest;
use App\Http\Resources\DiscountResource;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function index()
    {
        return DiscountResource::collection(Discount::all());
    }

    public function show($id)
    {
        $discount = Discount::findOrFail($id);

        return new DiscountResource($discount);
    }

    public function store(StoreDiscountRequest $request)
    {
        $discount = Discount::create($request->validated());

        return response()->json([
            'message' => 'Discount created successfully',
            'data' => new DiscountResource($discount),
        ], 201);
    }

    public function update(StoreDiscountRequest $request, $id)
    {
        $discount = Discount::findOrFail($id);

        $discount->update($request->validated());

        return response()->json([
            'message' => 'Discount updated successfully',
            'data' => new DiscountResource($discount),
        ]);
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);

        $discount->delete();

        return response()->json(['message' => 'Discount deleted successfully']);
    }
}
