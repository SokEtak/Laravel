<x-layout title="Inventory List">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">List of Inventories ({{ count($inventories) }})</h2>
            <a href="{{ route('inventories.create') }}" class="btn btn-primary">Add Inventory</a>
        </div>

        <div class="card shadow rounded-4 border-0 scroll-container p-4">
            <div class="list-group list-group-flush">
                @forelse($inventories as $inventory)
                    <div class="list-group-item p-3 position-relative border-0 shadow-sm rounded-3 mb-3 bg-white">
                        <h5 class="fw-bold mb-2">
                            <a href="{{ route('inventories.show', $inventory['id']) }}" class="text-decoration-none text-primary">
                                Inventory #{{ $inventory['id'] }}
                            </a>
                        </h5>
                        <div><strong>Quantity:</strong> {{ $inventory['quantity'] }}</div>
                        <div>
                            <strong>Created At:</strong>
                            {{ \Carbon\Carbon::parse($inventory['created_at'])->timezone('Asia/Phnom_Penh')->format('Y-m-d H:i') }}
                        </div>
                        <div>
                            <strong>Updated At:</strong>
                            {{ \Carbon\Carbon::parse($inventory['updated_at'])->timezone('Asia/Phnom_Penh')->format('Y-m-d H:i') }}
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No inventories found.</p>
                @endforelse
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .scroll-container {
                max-height: 75vh;
                overflow-y: auto;
            }
        </style>
    @endpush
</x-layout>
