<x-layout title="Edit Category">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Edit Category: {{ $category['category_name'] ?? 'Unnamed' }}</h2>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 bg-white">
            <form action="{{ route('categories.update', $category['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="category_name" class="form-label fw-semibold">Category Name</label>
                        <input type="text" name="category_name" class="form-control form-control-lg rounded-3"
                               value="{{ old('category_name', $category['category_name'] ?? '') }}" required>
                        @error('category_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="category_description" class="form-label fw-semibold">Category Description</label>
                        <input type="text" name="category_description" class="form-control form-control-lg rounded-3"
                               value="{{ old('category_description', $category['category_description'] ?? '') }}" required>
                        @error('category_description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-dark btn-lg px-4 rounded-3">Update Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
