<x-layout title="Edit Product">
    <style>
        body {
            background-color: #1E1E2F;
            color: #F0F0F0;
        }

        .form-control:focus,
        textarea:focus {
            background-color: #505066;      /* lighter than before */
            color: #ffffff;                 /* ensure text is bright */
            border-color: #00B3FF;
            box-shadow: 0 0 6px #00B3FF;
            outline: none;
        }

        .form-card {
            background-color: #2A2A40;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            padding: 2rem;
        }

        .form-label {
            color: #E0E0E0;
            font-weight: 600;
        }

        .form-control,
        .form-select,
        textarea {
            background-color: #3B3B52;
            color: #ffffff;
            border: 1px solid #555;
            border-radius: 10px;
            transition: 0.3s;
        }

        .form-control:focus,
        .form-select:focus,
        textarea:focus {
            background-color: #44455A;
            border-color: #00B3FF;
            box-shadow: 0 0 5px #00B3FF;
        }

        .btn-secondary {
            background-color: #444;
            color: #fff;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #555;
        }

        .btn-success {
            background-color: #00B3FF;
            border: none;
            color: #fff;
            font-weight: 600;
        }

        .btn-success:hover {
            background-color: #009EDB;
        }
    </style>

    <div class="container mt-5">
        <form action="{{ route('products.update', $product['id']) }}" method="POST" class="form-card">
            @csrf
            @method('PUT')
        <h2 class="mb-4 text-white fw-bold" style="font-size: 1.8rem;">Edit Product - {{ $product['product_name'] }}</h2>

            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control"
                       value="{{ old('product_name', $product['product_name']) }}" required>
            </div>

            <div class="mb-3">
                <label for="product_description" class="form-label">Description</label>
                <textarea name="product_description" id="product_description" rows="3" class="form-control" required>{{ old('product_description', $product['product_description']) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="SKU" class="form-label">SKU</label>
                <input type="text" name="SKU" id="SKU" class="form-control" value="{{ old('SKU', $product['SKU']) }}" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" step="0.01"
                       value="{{ old('price', $product['price']) }}" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option disabled>Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product['category']['id'] ?? null) == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="discount_id" class="form-label">Discount</label>
                <select name="discount_id" id="discount_id" class="form-select" required>
                    <option disabled>Select a discount</option>
                    @foreach ($discounts as $discount)
                        <option value="{{ $discount->id }}"
                            {{ old('discount_id', $product['discount']['id'] ?? null) == $discount->id ? 'selected' : '' }}>
                            {{ $discount->discount_name }} ({{ $discount->discount_percent }}%)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="inventory_quantity" class="form-label">Inventory Quantity</label>
                <input
                    type="number"
                    class="form-control @error('inventory_quantity') is-invalid @enderror"
                    id="inventory_quantity"
                    name="inventory_quantity"
                    value="{{ old('inventory_quantity', $product->inventory->quantity ?? '') }}"
                    min="0"
                    step="1"
                    placeholder="Enter quantity (e.g., 100)">
                @error('inventory_quantity')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>


            <div class="d-flex justify-content-end">
                <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-success">Update Product</button>
            </div>
        </form>
    </div>
</x-layout>
