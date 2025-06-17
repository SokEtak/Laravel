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

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('categories.edit', $category['id']) }}" class="btn btn-outline-info me-2">Edit</a>

                <!-- Trigger Delete Modal -->
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('categories.destroy', $category['id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this category?
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
