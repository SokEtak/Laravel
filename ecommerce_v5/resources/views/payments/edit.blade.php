{{--<x-layout title="Edit Product">--}}
{{--    <div class="container mt-5">--}}
{{--        <h2 class="mb-4">Edit Product - {{ $product['product_name'] }}</h2>--}}

{{--        <form action="{{ route('products.update', $product['id']) }}" method="POST" class="card shadow p-4 rounded-4 border-0">--}}
{{--            @csrf--}}
{{--            @method('PUT')--}}

{{--            --}}{{-- Product Name --}}
{{--            <div class="mb-3">--}}
{{--                <label for="product_name" class="form-label">Product Name</label>--}}
{{--                <input type="text" name="product_name" id="product_name" class="form-control"--}}
{{--                       value="{{ old('product_name', $product['product_name']) }}" required>--}}
{{--            </div>--}}

{{--            --}}{{-- Description --}}
{{--            <div class="mb-3">--}}
{{--                <label for="product_description" class="form-label">Description</label>--}}
{{--                <textarea name="product_description" id="product_description" rows="3" class="form-control" required>{{ old('product_description', $product['product_description']) }}</textarea>--}}
{{--            </div>--}}

{{--            --}}{{-- SKU --}}
{{--            <div class="mb-3">--}}
{{--                <label for="SKU" class="form-label">SKU</label>--}}
{{--                <input type="text" name="SKU" id="SKU" class="form-control" value="{{ old('SKU', $product['SKU']) }}" required>--}}
{{--            </div>--}}

{{--            --}}{{-- Price --}}
{{--            <div class="mb-3">--}}
{{--                <label for="price" class="form-label">Price</label>--}}
{{--                <input type="number" name="price" id="price" class="form-control" step="0.01"--}}
{{--                       value="{{ old('price', $product['price']) }}" required>--}}
{{--            </div>--}}

{{--            --}}{{-- Category --}}
{{--            <div class="mb-3">--}}
{{--                <label for="category_id" class="form-label">Category</label>--}}
{{--                <select name="category_id" id="category_id" class="form-select" required>--}}
{{--                    <option disabled>Select a category</option>--}}
{{--                    @foreach ($categories as $category)--}}
{{--                        <option value="{{ $category->id }}"--}}
{{--                            {{ old('category_id', $product['category']['id'] ?? null) == $category->id ? 'selected' : '' }}>--}}
{{--                            {{ $category->category_name }}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}

{{--            --}}{{-- Discount --}}
{{--            <div class="mb-3">--}}
{{--                <label for="discount_id" class="form-label">Discount</label>--}}
{{--                <select name="discount_id" id="discount_id" class="form-select" required>--}}
{{--                    <option disabled>Select a discount</option>--}}
{{--                    @foreach ($discounts as $discount)--}}
{{--                        <option value="{{ $discount->id }}"--}}
{{--                            {{ old('discount_id', $product['discount']['id'] ?? null) == $discount->id ? 'selected' : '' }}>--}}
{{--                            {{ $discount->discount_name }} ({{ $discount->discount_percent }}%)--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}

{{--            --}}{{-- Inventory --}}
{{--            <div class="mb-3">--}}
{{--                <label for="inventory_id" class="form-label">Inventory</label>--}}
{{--                <select name="inventory_id" id="inventory_id" class="form-select" required>--}}
{{--                    <option disabled>Select inventory</option>--}}
{{--                    @foreach ($inventories as $inventory)--}}
{{--                        <option value="{{ $inventory->id }}"--}}
{{--                            {{ old('inventory_id', $product['inventories.blade.php']['id'] ?? null) == $inventory->id ? 'selected' : '' }}>--}}
{{--                            ID: {{ $inventory->id }} - Quantity: {{ $inventory->quantity }}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}

{{--            --}}{{-- Buttons --}}
{{--            <div class="d-flex justify-content-end">--}}
{{--                <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">Cancel</a>--}}
{{--                <button type="submit" class="btn btn-success">Update Product</button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--</x-layout>--}}
