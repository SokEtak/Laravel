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

                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteDiscountModal">
                    Delete
                </button>
            </div>
        </div>
    </div>

     {{-- delete-confirmation --}}
    <x-alerts.delete_confirmation
        id="deleteDiscountModal"
        :action="route('discounts.destroy', $discount['id'])"
        title="Delete Dicount"
        body="Are you sure you want to delete the discount '{{ $discount['discount_name'] }}'?"
    />
</x-layout>