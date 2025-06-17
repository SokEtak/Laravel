<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with(['product', 'orderDetail'])->get();
        return OrderItemResource::collection($orderItems);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:order_details,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $orderItem = OrderItem::create($validator->validated());

        return new OrderItemResource($orderItem->load(['product', 'orderDetail']));
    }

    public function show($id)
    {
        $orderItem = OrderItem::with(['product', 'orderDetail'])->findOrFail($id);
        return new OrderItemResource($orderItem);
    }

    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'order_id' => 'sometimes|exists:order_details,id',
            'product_id' => 'sometimes|exists:products,id',
            'quantity' => 'sometimes|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $orderItem->update($validator->validated());

        return new OrderItemResource($orderItem->load(['product', 'orderDetail']));
    }

    public function destroy($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();

        return response()->json(['message' => 'Order item deleted successfully.'], 204);
    }
}
