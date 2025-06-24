<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\orderItems\StoreOrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderItem;


class OrderItemController extends Controller
{
//    public function index()
//    {
//        try {
//            // Fetch all order items with their associated products and order details
//            $orderItems = OrderItem::with(['product', 'order'])->get();
//        } catch (\Exception $e) {
//            // Log the error and return an empty collection or handle it as needed
//            \Log::error('Error fetching order items: ' . $e->getMessage());
//            $orderItems = collect();// Initialize an empty collection
//            dd();
//        }
//        return OrderItemResource::collection($orderItems);
//    }
//
////    public function store(StoreOrderItemRequest $request)
////    {
////        $orderItem = OrderItem::create($request->validated());
////        return new OrderItemResource($orderItem->load(['product', 'orderDetail']));
////    }
////
//    public function show($id)
//    {
//        try {
//            // Fetch the order item with its associated product and order detail
//            $orderItem = OrderItem::with(['product', 'orderDetail'])->findOrFail($id);
//             return new OrderItemResource($orderItem);
//        } catch (\Exception $e) {
//            // Log the error and handle it as needed
//            \Log::error('Error fetching order item: ' . $e->getMessage());
//            abort(404, 'Order item not found');
//        }
//    }
//
//    public function update(StoreOrderItemRequest $request, $id)
//    {
//
//        try{
//            $orderItem = OrderItem::findOrFail($id);
//            $orderItem->update($request->validated());
//
//            return new OrderItemResource($orderItem->load(['product', 'orderDetail']));
//
//        }
//        catch (\Exception $e) {
//            // Log the error and handle it as needed
//            \Log::error('Error updating order item: ' . $e->getMessage());
//            abort(404, 'Order item not found');
//        }
//    }
//
//    public function destroy($id)
//    {
//        try {
//            $orderItem = OrderItem::findOrFail($id);
//             $orderItem->delete();
//        return response()->json(['message' => 'Order item deleted successfully.'], 204);
//
//        } catch (\Exception $e) {
//            // Log the error and handle it as needed
//            \Log::error('Error deleting order item: ' . $e->getMessage());
//            abort(404, 'Order item not found');
//        }
//    }
}
