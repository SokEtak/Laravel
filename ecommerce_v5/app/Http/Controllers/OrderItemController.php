<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'product'])->get();
        return view('orderItems.index', compact('orderItems'));
    }

    public function create()
    {
        $orders = OrderDetail::all();
        $products = Product::all();

        return view('orderItems.create', compact('orders', 'products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:order_details,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        OrderItem::create($validator->validated());

        return redirect()->route('orderItems.index')->with('success', 'Order item created successfully.');
    }

    public function show($id)
    {
        $orderItem = OrderItem::with(['order', 'product'])->findOrFail($id);
        return view('orderItems.show', compact('orderItem'));
    }

    public function edit($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orders = OrderDetail::all();
        $products = Product::all();

        return view('orderItems.edit', compact('orderItem', 'orders', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:order_details,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update($validator->validated());

        return redirect()->route('orderItems.index')->with('success', 'Order item updated successfully.');
    }

    public function destroy($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();

        return redirect()->route('orderItems.index')->with('success', 'Order item deleted successfully.');
    }
}
