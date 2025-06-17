<x-layout title="Edit Inventory">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('inventories.index') }}" class="btn btn-secondary">← Back to List</a>
            <h2>Edit Inventory #{{ $inventory->id }}</h2>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white">
            <form action="{{ route('inventories.update', $inventory->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control bg-secondary text-white border-0 @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $inventory->quantity) }}" required min="0">
                    @error('quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="product_id" class="form-label">Associate Product (Optional)</label>
                    <select class="form-select bg-secondary text-white border-0 @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                        <option value="">Select a Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $inventory->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->product_name }} (SKU: {{ $product->SKU }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success">Update Inventory</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
