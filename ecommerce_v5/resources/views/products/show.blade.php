<x-layout title="Product Detail">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 text-white" style="background-color: #2a2d33;">
            <h2 class="mb-3 text-white text-center">{{ $product['product_name'] }}</h2>

            <div class="row mb-2">
                <div class="col-md-4"><strong>ID:</strong> {{ $product['id'] }}</div>
                <div class="col-md-4"><strong>SKU:</strong> {{ $product['SKU'] ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Price:</strong> ${{ number_format($product['price'] ?? 0, 2) }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4">
                    <strong>Category:</strong> {{ $product['category']['category_name'] ?? 'N/A' }}
                </div>
                <div class="col-md-4">
                    <strong>Discount:</strong>
                    @if($product['discount'])
                        {{ $product['discount']['discount_name'] }} ({{ $product['discount']['discount_percent'] }}%)
                    @else
                        No Discount
                    @endif
                </div>
                <div class="col-md-4">
                    <strong>Quantity:</strong>
                    @if($product['inventory'])
                        {{ $product['inventory']['quantity'] }}
                        <span class="{{ $product['inventory']['quantity'] < 10 ? 'text-danger' : 'text-success' }}">
                            {{ $product['inventory']['quantity'] >= 10 ? 'units available' : 'almost out of stock' }}
                        </span>
                    @else
                        N/A (No Inventory Linked)
                    @endif
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12 ">
                    <strong>Description:</strong> {{ $product['product_description'] ?? 'N/A' }}
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('products.edit', $product['id']) }}" class="btn btn-outline-info me-2">Edit</a>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div class="modal text-black" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('products.destroy', $product['id']) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this product?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
