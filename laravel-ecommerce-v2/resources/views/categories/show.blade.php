<x-layout title="Category Detail">
    <div class="container my-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">{{ $category['category_name'] ?? 'Unnamed Category' }}</h2>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 bg-white">
            <h5 class="text-muted mb-3">Category Information</h5>

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

                <form action="{{ route('categories.destroy', $category['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
