<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;

class OrderItemController extends Controller
{
//    public function index()
//    {
//        try {
//            // Fetch all order items with their associated orders and products
//            $orderItems = OrderItem::with(['order', 'product'])->get();
//        } catch (\Exception $e) {
//            // Log the error and return an empty collection or handle it as needed
//            \Log::error('Error fetching order items: ' . $e->getMessage());
//            $orderItems = collect();
//        }
//        return view('orderItems.index', compact('orderItems'));
//
//    }

    /*
    public function create()
    {
        $orders = OrderDetail::all();
        $products = Product::all();

        return view('orderItems.create', compact('orders', 'products'));
    }
    */


//    public function store(StoreOrderItemRequest $request)
//    {
//        $orderItem = $request->validated();
//
//        OrderItem::create($orderItem->validated());
//
//        return redirect()->route('orderItems.index')->with('success', 'Order item created successfully.');
//    }



//    public function show($id)
//    {
//       try {
//            $orderItem = OrderItem::with(['order', 'product'])->findOrFail($id);
//           return view('orderItems.show', compact('orderItem'));
//        } catch (\Exception $e) {
//            // Log the error and handle it as needed
//            \Log::error('Error fetching order item: ' . $e->getMessage());
//            abort(404, 'Order item not found');
//        }
//
//    }



//    public function edit($id)
//    {
//       try {
//            $orderItem = OrderItem::with(['order', 'product'])->findOrFail($id);
//            $orders = OrderDetail::all();
//            $products = Product::all();
//        } catch (\Exception $e) {
//            // Log the error and handle it as needed
//            \Log::error('Error fetching order item for edit: ' . $e->getMessage());
//            abort(404, 'Order item not found');
//        }
//        return view('orderItems.edit', compact('orderItem', 'orders', 'products'));
//    }



//    public function update(StoreOrderItemRequest $request, $id)
//    {
//        $orderItem = OrderItem::findOrFail($id);
//
//        $data = $request->validated();
//        $orderItem->update($data->validated());
//
//        return redirect()->route('orderItems.index')->with('success', 'Order item updated successfully.');
//    }


//    public function destroy($id)
//    {
//       try {
//            $orderItem = OrderItem::findOrFail($id);
//            $orderItem->delete();
//        } catch (\Exception $e) {
//            // Log the error and handle it as needed
//            \Log::error('Error deleting order item: ' . $e->getMessage());
//            return redirect()->route('orderItems.index')->with('error', 'Failed to delete order item.');
//        }
//        return redirect()->route('orderItems.index')->with('success', 'Order item deleted successfully.');
//    }

}
