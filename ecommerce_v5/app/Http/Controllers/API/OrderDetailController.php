<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDetailResource;
use App\Models\OrderDetail;
use App\Models\OrderItem;

class OrderDetailController extends Controller
{
    public function index()
    {
        $orderDetails = OrderDetail::with(['user', 'items.product', 'paymentDetail'])->get();

        return OrderDetailResource::collection($orderDetails);
    }

    public function store(StoreOrderRequest $request)
    {
        $order = OrderDetail::create([
            'user_id' => $request->user_id,
            'total' => $request->total,
            'provider' => $request->provider ?? null,
            'status' => $request->status ?? 'pending',
            'bank_detail' => $request->provider === 'bank' ? $request->bank_detail : null,
            'amount' => $request->amount ?? $request->total,
        ]);

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        return response()->json([
            'message' => 'Order created successfully',
            'data' => new OrderDetailResource($order->load('items.product'))
        ], 201);
    }

    public function show($id)
    {
        $orderDetail = OrderDetail::with('items.product','paymentDetail')->findOrFail($id);

        return new OrderDetailResource($orderDetail);
    }

    public function update(StoreOrderRequest $request, $id)
    {
        $orderDetail = OrderDetail::findOrFail($id);

        // Update order details
        $orderDetail->update([
            'user_id' => $request->user_id,
            'total' => $request->total,
            'provider' => $request->provider ?? $orderDetail->provider,
            'status' => $request->status ?? $orderDetail->status,
            'bank_detail' => $request->provider === 'bank' ? $request->bank_detail : null,
            'amount' => $request->amount ?? $orderDetail->amount,
            'updated_at' => now(),
        ]);

        // Refresh items
        $orderDetail->items()->delete();

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $orderDetail->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        return response()->json([
            'message' => 'Order updated successfully',
            'data' => new OrderDetailResource($orderDetail->load('items.product'))
        ]);
    }

    public function destroy($id)
    {
        $orderDetail = OrderDetail::findOrFail($id);

        $orderDetail->delete();

        return response()->json([
            'message' => 'Order deleted successfully'
        ]);
    }
}
