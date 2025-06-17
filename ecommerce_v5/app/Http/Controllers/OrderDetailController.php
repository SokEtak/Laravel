<?php

namespace App\Http\Controllers;

use App\Http\Requests\orders\StoreOrderDetailRequest;
use App\Http\Requests\orders\UpdateOrderDetailRequest;
use App\Models\Inventory;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\PaymentDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderDetailController extends Controller
{
    public function index()
    {
        $orderDetails = OrderDetail::all();
        return view('orderDetails.index', compact('orderDetails'));
    }

    public function create()
    {
        try {
            $products = Product::with('discount')->get();
            $users = User::all();
            $productsJson = $products->toJson(); // Pass products as JSON for JS
            return view('orderDetails.create', compact('users', 'products', 'productsJson'));
        } catch (\Exception $e) {
            Log::error("Error fetching products for order creation: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Could not fetch products.']);
        }
    }

    public function store(StoreOrderDetailRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();

        try {
            $calculatedTotal = 0;
            $orderItemsToCreate = [];
            $inventoryAdjustments = [];

            foreach ($data['items'] as $item) {
                $product = Product::with('discount')->findOrFail($item['product_id']);
                $itemPrice = $product->price;

                // --- MODIFIED DISCOUNT LOGIC FOR WEB STORE METHOD ---
                // Apply discount if it exists, is active, and has a positive percentage
                if ($product->discount && $product->discount->active && $product->discount->discount_percent > 0) {
                    // Assuming 'discount_percent' means it's always a percentage discount
                    $itemPrice -= ($product->price * $product->discount->discount_percent / 100);
                }
                // --- END MODIFIED DISCOUNT LOGIC ---

                $itemPrice = max(0, $itemPrice);

                $calculatedTotal += ($itemPrice * $item['quantity']);

                $orderItemsToCreate[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $itemPrice,
                ];

                $inventoryAdjustments[$product->id] = ($inventoryAdjustments[$product->id] ?? 0) - $item['quantity'];

                $inventory = Inventory::findOrFail($product->inventory_id);
                if ($inventory->quantity < $item['quantity']) {
                    DB::rollBack();
                    return redirect()->back()->withErrors(['error' => "Insufficient stock for product '{$product->name}'. Available: {$inventory->quantity}, Requested: {$item['quantity']}."])->withInput();
                }
            }

            $order = OrderDetail::create([
                'user_id' => $data['user_id'],
                'total' => $calculatedTotal,
            ]);

            foreach ($orderItemsToCreate as $itemData) {
                $order->items()->create($itemData);
            }

            foreach ($inventoryAdjustments as $productId => $change) {
                $product = Product::findOrFail($productId);
                $inventory = Inventory::findOrFail($product->inventory_id);
                $inventory->increment('quantity', $change);
            }

            $bankDetail = ($data['provider'] === 'bank') ? ($data['bank_detail'] ?? null) : null;

            PaymentDetail::create([
                'order_id' => $order->id,
                'provider' => $data['provider'],
                'amount' => $calculatedTotal,
                'status' => $data['status'],
                'bank_detail' => $bankDetail,
            ]);

            DB::commit();

            return redirect()->route('orderDetails.index')->with('success', 'Order and payment created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Order creation failed: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
            return redirect()->back()->withErrors(['error' => 'Something went wrong during order creation: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        try {
            $orderDetail = OrderDetail::with(['user', 'items.product.discount', 'paymentDetail'])->findOrFail($id);
            return view('orderDetails.show', compact('orderDetail'));
        } catch (\Exception $e) {
            Log::error("Error fetching order detail with ID {$id}: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Order detail not found.']);
        }
    }

    public function edit($id)
    {
        try {
            $orderDetail = OrderDetail::with(['user', 'items.product.discount', 'paymentDetail'])->findOrFail($id);
            $users = User::all();
            $products = Product::with('discount')->get();
            $productsJson = $products->toJson(); // Pass products as JSON for JS
            return view('orderDetails.edit', compact('orderDetail', 'users', 'products', 'productsJson'));
        } catch (\Exception $e) {
            Log::error("Error fetching order detail for editing with ID {$id}: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Order detail not found.']);
        }
    }

    public function update(UpdateOrderDetailRequest $request, $id)
    {
        $order = OrderDetail::findOrFail($id);
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $calculatedTotal = 0;
            $originalOrderItems = $order->items->keyBy('product_id');
            $inventoryAdjustments = [];
            $newOrderItemsData = [];

            foreach ($data['items'] as $incomingItem) {
                $productId = $incomingItem['product_id'];
                $newQuantity = $incomingItem['quantity'];

                $product = Product::with('discount')->findOrFail($productId);
                $itemPrice = $product->price;

                // --- MODIFIED DISCOUNT LOGIC FOR WEB UPDATE METHOD ---
                // Apply discount if it exists, is active, and has a positive percentage
                if ($product->discount && $product->discount->active && $product->discount->discount_percent > 0) {
                    // Assuming 'discount_percent' means it's always a percentage discount
                    $itemPrice -= ($product->price * $product->discount->discount_percent / 100);
                }
                // --- END MODIFIED DISCOUNT LOGIC ---

                $itemPrice = max(0, $itemPrice);

                $calculatedTotal += ($itemPrice * $newQuantity);

                $oldQuantity = 0;
                if (isset($originalOrderItems[$productId])) {
                    $oldQuantity = $originalOrderItems[$productId]->quantity;
                }

                $quantityChange = $newQuantity - $oldQuantity;

                $inventoryAdjustments[$productId] = ($inventoryAdjustments[$productId] ?? 0) - $quantityChange;

                $inventory = Inventory::findOrFail($product->inventory_id);
                if ($quantityChange > 0 && $inventory->quantity < $quantityChange) {
                    DB::rollBack();
                    $currentStock = $inventory->quantity;
                    return redirect()->back()->withErrors(['error' => "Insufficient stock for product '{$product->name}' (ID: {$productId}). Current available: {$currentStock}. Required additional: {$quantityChange}."])->withInput();
                }

                $newOrderItemsData[$productId] = [
                    'product_id' => $productId,
                    'quantity' => $newQuantity,
                    'price' => $itemPrice,
                ];
            }

            foreach ($originalOrderItems as $originalProductId => $originalOrderItem) {
                if (!isset($newOrderItemsData[$originalProductId])) {
                    $inventoryAdjustments[$originalProductId] = ($inventoryAdjustments[$originalProductId] ?? 0) + $originalOrderItem->quantity;
                    $originalOrderItem->delete();
                }
            }

            $order->update([
                'user_id' => $data['user_id'],
                'total' => $calculatedTotal,
                'updated_at' => now(),
            ]);

            foreach ($newOrderItemsData as $productId => $itemData) {
                if (isset($originalOrderItems[$productId])) {
                    $originalOrderItems[$productId]->update($itemData);
                } else {
                    $order->items()->create($itemData);
                }
            }

            foreach ($inventoryAdjustments as $productId => $change) {
                $product = Product::findOrFail($productId);
                $inventory = Inventory::findOrFail($product->inventory_id);

                $newInventoryQuantity = $inventory->quantity + $change;

                if ($newInventoryQuantity < 0) {
                    DB::rollBack();
                    return redirect()->back()->withErrors(['error' => "Inventory calculation error for product ID {$productId}: would result in negative stock."])->withInput();
                }

                $inventory->quantity = $newInventoryQuantity;
                $inventory->save();
            }

            $bankDetail = ($data['provider'] === 'bank') ? ($data['bank_detail'] ?? null) : null;

            $payment = $order->paymentDetail;
            if ($payment) {
                $payment->update([
                    'provider' => $data['provider'],
                    'amount' => $calculatedTotal,
                    'status' => $data['status'],
                    'bank_detail' => $bankDetail,
                ]);
            } else {
                PaymentDetail::create([
                    'order_id' => $order->id,
                    'provider' => $data['provider'],
                    'amount' => $calculatedTotal,
                    'status' => $data['status'],
                    'bank_detail' => $bankDetail,
                ]);
            }

            DB::commit();

            return redirect()->route('orderDetails.index')->with('success', 'Order updated successfully and inventory adjusted.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Order update failed for order ID: {$id}. Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
            return redirect()->back()->withErrors(['error' => 'Something went wrong during the update: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {

        $order = OrderDetail::findOrFail($id);

        DB::beginTransaction();

        try {
            foreach ($order->items as $item) {
                $product = Product::findOrFail($item->product_id);
                $inventory = Inventory::findOrFail($product->inventory_id);
                $inventory->increment('quantity', $item->quantity);
            }

            if ($order->paymentDetail) {
                $order->paymentDetail()->delete();
            }

            $order->items()->delete();
            $order->delete();

            DB::commit();

            return redirect()->route('orderDetails.index')->with('success', 'Order detail and associated inventory deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Order deletion failed for order ID: {$id}. Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
            return redirect()->back()->withErrors(['error' => 'Something went wrong during order deletion: ' . $e->getMessage()]);
        }
    }
}
