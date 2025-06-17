<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\orders\StoreOrderDetailRequest;
use App\Http\Requests\orders\UpdateOrderDetailRequest;
use App\Http\Resources\OrderDetailResource;
use App\Models\Inventory;
use App\Models\OrderDetail;
use App\Models\PaymentDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderDetailController extends Controller
{
    public function index()
    {
        try {
            $orderDetails = OrderDetail::with(['user', 'items.product.discount', 'paymentDetail'])->get();
            return OrderDetailResource::collection($orderDetails);
        } catch (\Exception $e) {
            Log::error("Error fetching order details: " . $e->getMessage());
            return response()->json(['message' => 'Error fetching order details.'], 500);
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

                // --- MODIFIED DISCOUNT LOGIC FOR API STORE METHOD ---
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
                    return response()->json(['message' => "Insufficient stock for product '{$product->name}' (ID: {$product->id}). Available: {$inventory->quantity}, Requested: {$item['quantity']}."], 400);
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

            return response()->json([
                'message' => 'Order and payment created successfully.',
                'data' => new OrderDetailResource($order->load(['user', 'items.product.discount', 'paymentDetail']))
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Order creation failed: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
            return response()->json(['message' => 'Something went wrong during order creation: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $orderDetail = OrderDetail::with(['user', 'items.product.discount', 'paymentDetail'])->findOrFail($id);
            return new OrderDetailResource($orderDetail);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Order detail not found.'], 404);
        } catch (\Exception $e) {
            Log::error("Error fetching order detail with ID {$id}: " . $e->getMessage());
            return response()->json(['message' => 'Error fetching order detail.'], 500);
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

                // --- MODIFIED DISCOUNT LOGIC FOR API UPDATE METHOD ---
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
                    throw new \Exception("Insufficient stock for product '{$product->name}' (ID: {$productId}). Current available: {$currentStock}. Required additional: {$quantityChange}.");
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
                    throw new \Exception("Inventory calculation error for product ID {$productId}: would result in negative stock.");
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

            return response()->json([
                'message' => 'Order updated successfully and inventory adjusted.',
                'data' => new OrderDetailResource($order->load(['user', 'items.product.discount', 'paymentDetail']))
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Order update failed for order ID: {$id}. Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
            return response()->json(['message' => 'Something went wrong during the update: ' . $e->getMessage()], 500);
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

            return response()->json(['message' => 'Order detail and associated inventory deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Order deletion failed for order ID: {$id}. Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
            return response()->json(['message' => 'Something went wrong during order deletion: ' . $e->getMessage()], 500);
        }
    }
}
