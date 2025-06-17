<x-layout title="Add New Product">
    <div class="container mt-5">
        <div class="card border-0 shadow-sm rounded-4 px-4 py-3" style="background-color: #4ED7F1;">
        <div class="card-header border-0 bg-white px-0 pb-0">
                <h3 class="fw-semibold">Create New Product</h3>
                <p class="text-muted">Fill out the form below to add a new product to the catalog.</p>
            </div>

            <div class="card-body px-0">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="product_name" class="form-label fw-semibold">Product Name</label>
                            <input type="text" name="product_name" class="form-control form-control-lg rounded-3" value="{{ old('product_name') }}" required>
                            @error('product_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="SKU" class="form-label fw-semibold">SKU</label>
                            <input type="text" name="SKU" class="form-control form-control-lg rounded-3" value="{{ old('SKU') }}">
                            @error('SKU') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">Price ($)</label>
                            <input type="number" step="0.01" name="price" class="form-control form-control-lg rounded-3" value="{{ old('price') }}" required>
                            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label fw-semibold">Category</label>
                            <select name="category_id" class="form-select form-select-lg rounded-3" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="discount_id" class="form-label fw-semibold">Discount</label>
                            <select name="discount_id" class="form-select form-select-lg rounded-3">
                                <option value="">No Discount</option>
                                @foreach ($discounts as $discount)
                                    <option value="{{ $discount->id }}" {{ old('discount_id') == $discount->id ? 'selected' : '' }}>
                                        {{ $discount->discount_name }} ({{ $discount->discount_percent }}%)
                                    </option>
                                @endforeach
                            </select>
                            @error('discount_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="inventory_id" class="form-label fw-semibold">Inventory</label>
                            <select name="inventory_id" class="form-select form-select-lg rounded-3" required>
                                <option value="">Select Inventory</option>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}" {{ old('inventory_id') == $inventory->id ? 'selected' : '' }}>
                                        Qty: {{ $inventory->quantity }}
                                    </option>
                                @endforeach
                            </select>
                            @error('inventory_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12">
                            <label for="product_description" class="form-label fw-semibold">Description</label>
                            <textarea name="product_description" class="form-control form-control-lg rounded-3" rows="4">{{ old('product_description') }}</textarea>
                            @error('product_description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-dark btn-lg px-4 rounded-3">Create Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
