<x-layout title="Category Detail">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">{{ $category['category_name'] ?? 'Unnamed Category' }}</h2>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 text-white" style="background-color: #2a2d33;">
            <h5 class="text-white mb-3">Category Information</h5>

            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>ID:</strong> {{ $category['id'] ?? 'N/A' }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-12">
                    <strong>Description:</strong> {{ $category['category_description'] ?? 'N/A' }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <div>
                        <strong>Created:</strong> {{ $category['created_at'] ? date('F j, Y g:i A', strtotime($category['created_at'])) : 'N/A' }}
                    </div>
                    <div>
                        <strong>Updated:</strong> {{ $category['updated_at'] ? date('F j, Y g:i A', strtotime($category['updated_at'])) : 'N/A' }}
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('categories.edit', $category['id']) }}" class="btn btn-outline-info me-2">Edit</a>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteModal">
                    Delete
                </button>
            </div>
        </div>
    </div>

    {{-- delete-confirmation --}}
    <x-alerts.delete_confirmation
        id="deleteModal"
        :action="route('categories.destroy', $category['id'])"
        title="Delete Category"
        body="Are you sure you want to delete the category '{{ $category['category_name'] }}'?"
    />
</x-layout>
