<x-layout title="Discount Detail">
    <div class="container my-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">{{ $discount['discount_name'] ?? 'Unnamed Discount' }}</h2>
            <a href="{{ route('discounts.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 bg-white">
            <h5 class="text-muted mb-3">Discount Information</h5>

            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>ID:</strong> {{ $discount['id'] ?? 'N/A' }}
                </div>
                <div class="col-md-6">
                    <strong>Active:</strong> {{ isset($discount['active']) && $discount['active'] ? 'Yes' : 'No' }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Discount Percent:</strong> {{ $discount['discount_percent'] ?? 0 }}%
                </div>
                <div class="col-md-6">
                    <strong>Description:</strong> {{ $discount['discount_description'] ?? 'N/A' }}
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('discounts.edit', $discount['id']) }}" class="btn btn-outline-info me-2">Edit</a>

                <form action="{{ route('discounts.destroy', $discount['id']) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this discount?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
