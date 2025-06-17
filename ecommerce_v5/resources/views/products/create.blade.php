<x-layout title="Create New Product">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">← Back to List</a>
            <h2>Create New Product</h2>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" class="form-control bg-secondary text-white border-0 @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name') }}" required>
                    @error('product_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="product_description" class="form-label">Description</label>
                    <textarea class="form-control bg-secondary text-white border-0 @error('product_description') is-invalid @enderror" id="product_description" name="product_description" rows="3">{{ old('product_description') }}</textarea>
                    @error('product_description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="SKU" class="form-label">SKU</label>
                    <input type="text" class="form-control bg-secondary text-white border-0 @error('SKU') is-invalid @enderror" id="SKU" name="SKU" value="{{ old('SKU') }}" required>
                    @error('SKU')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control bg-secondary text-white border-0 @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required min="0">
                    @error('price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select bg-secondary text-white border-0 @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        <option value="">Select a Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="discount_id" class="form-label">Discount (Optional)</label>
                    <select class="form-select bg-secondary text-white border-0 @error('discount_id') is-invalid @enderror" id="discount_id" name="discount_id">
                        <option value="">No Discount</option>
                        @foreach ($discounts as $discount)
                            <option value="{{ $discount->id }}" {{ old('discount_id') == $discount->id ? 'selected' : '' }}>
                                {{ $discount->discount_name }} ({{ $discount->discount_percent }}%)
                            </option>
                        @endforeach
                    </select>
                    @error('discount_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inventory_quantity" class="form-label">Initial Inventory Quantity</label>
                    <input
                        type="number"
                        class="form-control bg-secondary text-white border-0 @error('inventory_quantity') is-invalid @enderror"
                        id="inventory_quantity"
                        name="inventory_quantity"
                        value="{{ old('inventory_quantity') }}"
                        min="1"
                        step="1"
                        placeholder="Enter quantity (e.g., 100)">
                    @error('inventory_quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success">Create Product</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
