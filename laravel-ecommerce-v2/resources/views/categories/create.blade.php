<x-layout title="Add New Category">
    <div class="container mt-5">
        <div class="card border-0 shadow-sm rounded-4 px-4 py-3" style="background-color: #4ED7F1;">
            <div class="card-header border-0 bg-white px-0 pb-0">
                <h3 class="fw-semibold">Create New Category</h3>
                <p class="text-muted">Fill out the form below to add a new product category.</p>
            </div>

            <div class="card-body px-0">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="category_name" class="form-label fw-semibold">Category Name</label>
                            <input type="text" name="category_name" class="form-control form-control-lg rounded-3" value="{{ old('category_name') }}" required>
                            @error('category_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12">
                            <label for="category_description" class="form-label fw-semibold">Description</label>
                            <textarea name="category_description" class="form-control form-control-lg rounded-3" rows="4">{{ old('category_description') }}</textarea>
                            @error('category_description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-dark btn-lg px-4 rounded-3">Create Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
