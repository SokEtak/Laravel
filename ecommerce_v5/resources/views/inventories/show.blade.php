<!-- resources/views/inventories/show.blade.php -->
<x-layout title="Inventory Detail">
    <div class="container my-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('inventories.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white">
            <h2 class="mb-3">Inventory ID #{{ $inventory['id'] }}</h2>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>ID:</strong> {{ $inventory['id'] }}
                </div>
                <div class="col-md-6">
                    <strong>Quantity:</strong> {{ $inventory['quantity'] }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Created At:</strong>
                    {{ \Carbon\Carbon::parse($inventory['created_at'])->timezone('Asia/Phnom_Penh')->format('Y-m-d H:i') }}
                </div>
                <div class="col-md-6">
                    <strong>Updated At:</strong>
                    {{ \Carbon\Carbon::parse($inventory['updated_at'])->timezone('Asia/Phnom_Penh')->format('Y-m-d H:i') }}
                </div>
            </div>

            @if(isset($inventory['product']))
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Product:</strong>
                        <a href="{{ route('products.show', $inventory['product']['id']) }}" class="text-info text-decoration-none">
                            {{ $inventory['product']['product_name'] ?? 'N/A' }}
                        </a>
                    </div>
                    <div class="col-md-6">
                        <strong>Product SKU:</strong> {{ $inventory['product']['SKU'] ?? 'N/A' }}
                    </div>
                </div>
            @else
                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Product:</strong> N/A (No Product Linked)
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('inventories.edit', $inventory['id']) }}" class="btn btn-outline-info me-2">Edit</a>
            </div>
        </div>
    </div>
</x-layout>
