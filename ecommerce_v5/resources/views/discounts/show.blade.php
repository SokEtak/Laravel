<x-layout title="Discount Detail">
   @php
    $timezone = 'Asia/Phnom_Penh';

    $createdAt = isset($discount['created_at']) 
        ? \Carbon\Carbon::parse($discount['created_at'])->timezone($timezone)->format('F j, Y, g:i A') 
        : 'N/A';

    $updatedAt = isset($discount['updated_at']) 
        ? \Carbon\Carbon::parse($discount['updated_at'])->timezone($timezone)->format('F j, Y, g:i A') 
        : 'N/A';
@endphp

    <div class="container my-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('discounts.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white">
            <h2 class="mb-3 text-white">{{ $discount['discount_name'] ?? 'Unnamed Discount' }}</h2>

            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>ID:</strong> {{ $discount['id'] ?? 'N/A' }}
                </div>
                <div class="col">
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

            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Created At:</strong> {{ $createdAt }}
                </div>
                <div class="col-md-6">
                    <strong>Updated At:</strong> {{ $updatedAt }}
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('discounts.edit', $discount['id']) }}" class="btn btn-outline-info me-2">Edit</a>

                <!-- Trigger Delete Modal -->
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteDiscountModal">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div class="modal fade" id="deleteDiscountModal" tabindex="-1" aria-labelledby="deleteDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('discounts.destroy', $discount['id']) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteDiscountModalLabel">Delete Discount</h5>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this discount?
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
