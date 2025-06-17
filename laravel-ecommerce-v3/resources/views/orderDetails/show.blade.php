<x-layout title="Inventory Detail">
    <div class="container my-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Inventory ID #{{ $inventory['id'] }}</h2>
            <a href="{{ route('inventories.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 bg-white">
            <h5 class="text-muted mb-3">Inventory Information</h5>

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
                        <a href="{{ route('products.show', $inventory['product']['id']) }}">
                            {{ $inventory['product']['product_name'] ?? 'N/A' }}
                        </a>
                    </div>
                    <div class="col-md-6">
                        <strong>Product SKU:</strong> {{ $inventory['product']['SKU'] ?? 'N/A' }}
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('inventories.edit', $inventory['id']) }}" class="btn btn-outline-info me-2">Edit</a>

                <form action="{{ route('inventories.destroy', $inventory['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this inventory?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
