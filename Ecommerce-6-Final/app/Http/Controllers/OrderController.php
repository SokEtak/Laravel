<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        $orders = Order::with('user', 'orderItems.product')->get();
        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }

    public function create(): Response
    {
        $users = User::all(['id', 'username']);
        $products = Product::all(['id', 'name', 'price']);
        return Inertia::render('Orders/Create', [
            'users' => $users,
            'products' => $products,
        ]);
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $order = Order::create($request->only('user_id', 'total_price', 'status'));

            foreach ($request->items as $itemData) {
                $order->orderItems()->create($itemData);
            }

            DB::commit();
            return redirect()->route('orders.show', $order)->with('success', 'Order created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create order: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Order $order): Response
    {
        $order->load('user', 'orderItems.product', 'payment.paymentMethod');
        $products = Product::all(['id', 'name', 'price']);
        return Inertia::render('Orders/Show', [
            'order' => $order,
            'products' => $products,
        ]);
    }

    public function edit(Order $order): Response
    {
        $users = User::all(['id', 'username']);
        $products = Product::all(['id', 'name', 'price']);
        $order->load('orderItems');
        return Inertia::render('Orders/Edit', [
            'order' => $order,
            'users' => $users,
            'products' => $products,
        ]);
    }

    public function update(UpdateOrderRequest $request, Order $order): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $order->update($request->only('user_id', 'total_price', 'status'));

            if ($request->has('items')) {
                $order->orderItems()->delete();
                foreach ($request->items as $itemData) {
                    $order->orderItems()->create($itemData);
                }
            }

            DB::commit();
            return redirect()->route('orders.show', $order)->with('success', 'Order updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update order: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }

    // --- Methods to manage order items within an order ---
    public function addItem(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $item = $order->orderItems()->where('product_id', $request->product_id)->first();

        if ($item) {
            $item->quantity += $request->quantity;
            $item->price = $request->price;
            $item->save();
            $message = 'Product quantity updated in order!';
        } else {
            $order->orderItems()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);
            $message = 'Product added to order!';
        }

        return redirect()->route('orders.show', $order)->with('success', $message);
    }

    public function updateItem(Request $request, Order $order, int $productId): RedirectResponse
    {
        $request->validate([
            'quantity' => ['sometimes', 'integer', 'min:0'],
            'price' => ['sometimes', 'numeric', 'min:0'],
        ]);

        $item = $order->orderItems()->where('product_id', $productId)->first();

        if (!$item) {
            return redirect()->back()->with('error', 'Order item not found.');
        }

        if ($request->has('quantity') && $request->quantity == 0) {
            $item->delete();
            return redirect()->route('orders.show', $order)->with('success', 'Product removed from order!');
        } else {
            $item->update($request->only('quantity', 'price'));
            return redirect()->route('orders.show', $order)->with('success', 'Order item updated!');
        }
    }

    public function removeItem(Order $order, int $productId): RedirectResponse
    {
        $item = $order->orderItems()->where('product_id', $productId)->first();

        if ($item) {
            $item->delete();
            return redirect()->route('orders.show', $order)->with('success', 'Product removed from order!');
        }

        return redirect()->back()->with('error', 'Order item not found.');
    }
}
