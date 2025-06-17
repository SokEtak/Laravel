<x-layout title="Edit Category">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-2">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">← Back to List</a>
            </div>
        </div>

        <div class="card shadow p-4 border-0 rounded-4 text-white" style="background-color: #2a2d33;">
            <h2 class="text-white mb-3">Edit Category: {{ $category['category_name'] ?? 'Unnamed' }}</h2>
            <form action="{{ route('categories.update', $category['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-white">Category Name</label>
                        <input type="text" name="category_name" class="form-control form-control-lg rounded-3 bg-light text-dark"
                               value="{{ old('category_name', $category['category_name']) }}" required>
                        @error('category_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-white">Category Description</label>
                        <input type="text" name="category_description" class="form-control form-control-lg rounded-3 bg-light text-dark"
                               value="{{ old('category_description', $category['category_description']) }}" required>
                        @error('category_description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-outline-light btn-lg px-4">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
