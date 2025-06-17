<x-layout title="Add Order Item">
    <div class="container mt-5">
        <div class="card border-0 shadow-sm rounded-4 px-4 py-3" style="background-color: #B8F1D6;">
            <div class="card-header border-0 bg-white px-0 pb-0">
                <h3 class="fw-semibold">Add Order Item</h3>
                <p class="text-muted">Fill out the form below to create a new order item.</p>
            </div>

            <div class="card-body px-0">
                <form action="{{ route('orderItems.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="order_id" class="form-label fw-semibold">Order</label>
                            <select name="order_id" class="form-select form-select-lg rounded-3" required>
                                <option value="">Select Order</option>
                                @foreach($orders as $order)
                                    <option value="{{ $order['id'] }}" {{ old('order_id') == $order['id'] ? 'selected' : '' }}>
                                        Order #{{ $order['id'] }} - by {{ $order['order_by'] ?? 'User '.$order['user_id'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('order_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="product_id" class="form-label fw-semibold">Product</label>
                            <select name="product_id" class="form-select form-select-lg rounded-3" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product['id'] }}" {{ old('product_id') == $product['id'] ? 'selected' : '' }}>
                                        {{ $product['product_name'] }} (${{ number_format($product['price'], 2) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="quantity" class="form-label fw-semibold">Quantity</label>
                            <input type="number" name="quantity" min="1" class="form-control form-control-lg rounded-3"
                                   value="{{ old('quantity', 1) }}" required>
                            @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success btn-lg px-4 rounded-3">Add Item</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
