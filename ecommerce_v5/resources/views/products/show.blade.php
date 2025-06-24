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
                    <strong>Category:
                        <a href="{{ route('categories.show', $product->category->id) }}"
                           class="text-info text-decoration-none">
                            {{ $product->category->category_name ?? 'N/A' }}
                        </a>
                    </strong>
                </div>
                <div class="col-md-4">
                    <strong>Discount:</strong>
                    @if($product['discount'])
                        <a class="text-info text-decoration-none"
                           href={{ route('discounts.show',$product['discount']['id']) }}> {{ $product['discount']['discount_name'] }}
                            ({{ $product['discount']['discount_percent'] }}%)</a>
                    @else
                        No Discount
                    @endif
                </div>
                <div class="col-md-4">
                    <strong>Quantity:</strong>
                    @if($product['inventory'])
                        <a href="{{ route('inventories.show', $product['inventory']['id']) }}"
                           class="text-info text-decoration-none">
                            {{ $product['inventory']['quantity'] ?? 'N/A' }}
                        </a>
                        <span class="{{ $product['inventory']['quantity'] < 10 ? 'text-danger' : 'text-success' }}">
                            {{ $product['inventory']['quantity'] >= 10 ? 'units available' : 'almost out of stock' }}
                        </span>
                    @else
                        N/A (No Inventory Linked)
                    @endif
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 mb-0">
                    <strong>Description:</strong> {{ $product['product_description'] ?? 'N/A' }}
                </div>

                <div class="col-md-4">
                    <strong>Created:</strong> {{ \Carbon\Carbon::parse($product->created_at)->timezone('Asia/Phnom_Penh')->format('Y-m-d H:i:s') }}
                </div>

                <div class="col-md-4">
                    <strong>Updated:</strong> {{ \Carbon\Carbon::parse($product->updated_at)->timezone('Asia/Phnom_Penh')->format('Y-m-d H:i:s') }}
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('products.edit', $product['id']) }}" class="btn btn-outline-info me-2">Edit</a>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteProductModal">
                    Delete
                </button>
            </div>
        </div>
    </div>

    {{-- delete-confirmation --}}
    <x-alerts.delete_confirmation
        id="deleteProductModal"
        :action="route('products.destroy', $product['id'])"
        title="Delete Product"
        body="Are you sure you want to delete the product '{{ $product['product_name'] }}'?"
    />

</x-layout>
