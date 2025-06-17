<x-layout title="Add New Category">
    <style>
        body {
            background-color: #1E1E2F;
            color: #F0F0F0;
        }

        .form-control:focus,
        textarea:focus {
            background-color: #505066;      /* lighter than before */
            color: #ffffff;                 /* ensure text is bright */
            border-color: #00B3FF;
            box-shadow: 0 0 6px #00B3FF;
            outline: none;
        }

        .form-card {
            background-color: #2A2A40;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            padding: 2rem;
        }

        .form-label {
            color: #E0E0E0;
            font-weight: 600;
        }

        .form-control,
        textarea {
            background-color: #3B3B52;
            color: #ffffff;
            border: 1px solid #555;
            border-radius: 10px;
            transition: 0.3s;
        }

        .form-control:focus,
        textarea:focus {
            background-color: #44455A;
            border-color: #00B3FF;
            box-shadow: 0 0 5px #00B3FF;
        }

        .btn-dark {
            background-color: #00B3FF;
            border: none;
            color: #fff;
            font-weight: 600;
        }

        .btn-dark:hover {
            background-color: #009EDB;
        }

        .text-muted {
            color: #A0A0B2 !important;
        }
    </style>

    <div class="container mt-5">
        <div class="form-card">
            <div class="mb-4">
                <h3 class="fw-semibold">Create New Category</h3>
                <p class="text-muted">Fill out the form below to add a new product category.</p>
            </div>

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control form-control-lg" value="{{ old('category_name') }}" required>
                        @error('category_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12">
                        <label for="category_description" class="form-label">Description</label>
                        <textarea name="category_description" class="form-control form-control-lg" rows="4">{{ old('category_description') }}</textarea>
                        @error('category_description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-dark btn-lg px-4 rounded-3">Create Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
