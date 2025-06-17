<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    public function index()
    {
        return DiscountResource::collection(Discount::all());
    }

    public function create()
    {
        return view('discounts.create');
    }

    public function show($id)
    {
        $discount = Discount::findOrFail($id);

        if(!$discount){
            return response()->json('Discount not found', 404);
        }

        return new DiscountResource($discount);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount_name' => 'required|string|max:255',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'discount_description' => 'required|',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $discount = Discount::create($validator->validated());
        return new DiscountResource($discount);
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);

        if(!$discount){
            return response()->json(['message' => 'Discount not found'], 404);
        }

        return view('discounts.edit', compact('discount'));
    }


    public function update(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);

        if(!$discount){
            return response()->json(['message' => 'Discount not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'discount_name' => 'required|string|max:255',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'discount_description' => 'required|',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $discount->update($request->all());

        return new DiscountResource($discount);
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        if(!$discount){
            return response()->json(['message' => 'Discount not found'], 404);
        }
        $discount->delete();
        return response()->json(null, 204);
    }
}
