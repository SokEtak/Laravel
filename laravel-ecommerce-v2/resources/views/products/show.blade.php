<x-layout title="Product Detail">
    <div class="container my-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">{{ $product['product_name'] }}</h2>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 bg-white">
            <h5 class="text-muted mb-3">Product Information</h5>

            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>SKU:</strong> {{ $product['SKU'] }}
                </div>
                <div class="col-md-6">
                    <strong>Price:</strong> ${{ number_format($product['price'], 2) }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Category:</strong> {{ $product['category']['category_name'] ?? 'N/A' }}
                </div>
                <div class="col-md-6">
                    <strong>Discount:</strong>
                    {{ $product['discount']['discount_name'] ?? 'N/A' }} ({{ $product['discount']['discount_percent'] ?? 0 }}%)
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Inventory:</strong> {{ $product['inventory']['quantity'] ?? 'N/A' }} units available
                </div>
                <div class="col-md-6">
                    <strong>Description:</strong> {{ $product['product_description'] }}
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('products.edit', $product['id']) }}" class="btn btn-outline-info me-2">Edit</a>

                <form action="{{ route('products.destroy', $product['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
