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
        $users = User::all();
        $products = Product::with('discount')->get();

        return view('orderDetails.create', compact('users', 'products'));
    }

    public function store(StoreOrderDetailRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $order = OrderDetail::create([
                'user_id' => $data['user_id'],
                'total' => $data['total'],
            ]);

            foreach ($data['items'] as $item) {
                $product = Product::with('discount')->findOrFail($item['product_id']);
                $itemPrice = $product->price;

                if ($product->discount) {
                    if ($product->discount->type === 'fixed') {
                        $itemPrice -= $product->discount->value;
                    } elseif ($product->discount->type === 'percentage') {
                        $itemPrice -= ($product->price * $product->discount->value / 100);
                    }
                }
                $itemPrice = max(0, $itemPrice);

                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $itemPrice,
                ]);

                $inventory = Inventory::findOrFail($product->inventory_id);
                $inventory->update([
                    'quantity' => $inventory->quantity - $item['quantity']
                ]);
            }

            PaymentDetail::create([
                'order_id' => $order->id,
                'provider' => $data['provider'],
                'amount' => $data['amount'],
                'status' => $data['status'],
                'bank_detail' => $data['bank_detail'] ?? null,
            ]);

            DB::commit();

            return redirect()->route('orderDetails.index')->with('success', 'Order and payment created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }

    public function show($id)
    {
        // Check for misconfigurations in model relationships or Route Model Binding if 'order_details.order_id' error occurs.
        $orderDetail = OrderDetail::with(['user', 'items.product.discount', 'paymentDetail'])->findOrFail($id);

        return view('orderDetails.show', compact('orderDetail'));
    }

    public function edit($id)
    {
        // Check for misconfigurations in model relationships or Route Model Binding if 'order_details.order_id' error occurs.
        $orderDetail = OrderDetail::with(['user', 'items.product.discount', 'paymentDetail'])->findOrFail($id);
        $users = User::all();
        $products = Product::with('discount')->get();

        return view('orderDetails.edit', compact('orderDetail', 'users', 'products'));
    }

    public function update(UpdateOrderDetailRequest $request, $id)
    {
        $data = $request->validated();

        $order = OrderDetail::findOrFail($id);

        DB::beginTransaction();

        try {
            // Update OrderDetail with user_id and total. Laravel automatically updates 'updated_at'.
            $order->update([
                'user_id' => $data['user_id'],
                'total' => $data['total'],
                'updated_at' => now(),
            ]);

            $originalOrderItems = $order->items->keyBy('product_id');
            $inventoryAdjustments = [];
            $productsToFetchForInventory = [];
            $updatedProductIds = [];

            // Process incoming items from the request.
            foreach ($data['items'] as $incomingItem) {
                $productId = $incomingItem['product_id'];
                $newQuantity = $incomingItem['quantity'];
                


                $productsToFetchForInventory[] = $productId;

                $product = Product::with('discount')->findOrFail($productId);
                $itemPrice = $product->price;

                if ($product->discount) {
                    if ($product->discount->type === 'fixed') {
                        $itemPrice -= $product->discount->value;
                    } elseif ($product->discount->type === 'percentage') {
                        $itemPrice -= ($product->price * $product->discount->value / 100);
                    }
                }
                $itemPrice = max(0, $itemPrice);


                if (isset($originalOrderItems[$productId])) {
                    $oldOrderItem = $originalOrderItems[$productId];
                    $oldQuantity = $oldOrderItem->quantity;

                    $quantityChange = $newQuantity - $oldQuantity;

                    if ($quantityChange !== 0) {
                        $inventoryAdjustments[$productId] = ($inventoryAdjustments[$productId] ?? 0) + $quantityChange;
                    }
                    // Update existing order item's quantity and price. 'updated_at' is automatic.
                    $oldOrderItem->quantity = $newQuantity;
                    $oldOrderItem->price = $itemPrice;
                    $oldOrderItem->save();

                    $updatedProductIds[] = $productId;
                } else {
                    $inventoryAdjustments[$productId] = ($inventoryAdjustments[$productId] ?? 0) + $newQuantity;
                    // Create new OrderItem. 'created_at' and 'updated_at' are automatic.
                    $order->items()->create([
                        'product_id' => $productId,
                        'quantity' => $newQuantity,
                        'price' => $itemPrice,
                    ]);
                    $updatedProductIds[] = $productId;
                }
            }

            // Process items removed from the original order.
            foreach ($originalOrderItems as $originalProductId => $originalOrderItem) {
                if (!in_array($originalProductId, $updatedProductIds)) {
                    $inventoryAdjustments[$originalProductId] = ($inventoryAdjustments[$originalProductId] ?? 0) - $originalOrderItem->quantity;
                    $originalOrderItem->delete();
                    $productsToFetchForInventory[] = $originalProductId;
                }
            }

            // Apply all accumulated inventory adjustments.
            $uniqueProductIds = array_unique($productsToFetchForInventory);
            $productsWithInventory = Product::whereIn('id', $uniqueProductIds)->with('inventory')->get()->keyBy('id');

            foreach ($inventoryAdjustments as $productId => $change) {
                if (!isset($productsWithInventory[$productId])) {
                    throw new \Exception("Product with ID {$productId} not found during inventory adjustment.");
                }
                $product = $productsWithInventory[$productId];
                $inventory = $product->inventory;

                if ($inventory === null) {
                    throw new \Exception("Inventory not found for product ID: {$productId}.");
                }

                $newInventoryQuantity = $inventory->quantity - $change;

                if ($newInventoryQuantity < 0) {
                    $currentStock = $inventory->quantity;
                    throw new \Exception("Insufficient stock for product '{$product->name}' (ID: {$productId}). Current available: {$currentStock}. Requested change implies a deduction of " . abs($change) . " units, which would result in negative stock.");
                }

                $inventory->quantity = $newInventoryQuantity;
                $inventory->save();
            }

            // Update PaymentDetail associated with the order.
            $payment = $order->paymentDetail;
            if ($payment) {
                $payment->update([
                    'provider' => $data['provider'],
                    'amount' => $data['amount'],
                    'status' => $data['status'],
                    'bank_detail' => $data['bank_detail'] ?? null,
                ]);
            } else {
                PaymentDetail::create([
                    'order_id' => $order->id,
                    'provider' => $data['provider'],
                    'amount' => $data['amount'],
                    'status' => $data['status'],
                    'bank_detail' => $data['bank_detail'] ?? null,
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
            // Restore inventory for items being deleted with the order
            foreach ($order->items as $item) {
                $product = Product::findOrFail($item->product_id);
                $inventory = Inventory::findOrFail($product->inventory_id);
                $inventory->increment('quantity', $item->quantity);
            }

            // Delete payment detail first if it exists
            if ($order->paymentDetail) {
                $order->paymentDetail()->delete();
            }

            // Delete order items
            $order->items()->delete();

            // Finally, delete the order itself
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
