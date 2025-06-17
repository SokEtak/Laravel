<x-layout title="Edit Order Item">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Edit Order Item #{{ $orderItem['id'] }}</h2>
            <a href="{{ route('orderItems.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 bg-white">
            <form action="{{ route('orderItems.update', $orderItem['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    {{-- Order Select --}}
                    <div class="col-md-6">
                        <label for="order_id" class="form-label fw-semibold">Order</label>
                        <select name="order_id" id="order_id" class="form-select form-select-lg rounded-3" required>
                            <option value="">Select Order</option>
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}"
                                    {{ old('order_id', $orderItem['order_id']) == $order->id ? 'selected' : '' }}>
                                    Order #{{ $order->id }} — {{ $order->order_by ?? 'User (ID: '.$order->user_id.')' }}
                                </option>
                            @endforeach
                        </select>
                        @error('order_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Product Select --}}
                    <div class="col-md-6">
                        <label for="product_id" class="form-label fw-semibold">Product</label>
                        <select name="product_id" id="product_id" class="form-select form-select-lg rounded-3" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ old('product_id', $orderItem['id']) == $product->id ? 'selected' : '' }}>
                                    {{ $product['product_name'] }} (${{ number_format($product->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Quantity --}}
                    <div class="col-md-6">
                        <label for="quantity" class="form-label fw-semibold">Quantity</label>
                        <input
                            type="number"
                            name="quantity"
                            id="quantity"
                            class="form-control form-control-lg rounded-3"
                            min="1"
                            value="{{ old('quantity', $orderItem['quantity']) }}"
                            required
                        >
                        @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-dark btn-lg px-4 rounded-3">Update Item</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
