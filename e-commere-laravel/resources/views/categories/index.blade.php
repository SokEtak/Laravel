<x-layout title="Category List">
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mb-5" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">List of Categories ({{ $categories->count() }})</h2>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">បន្ថែមប្រភេទទំនិញ</a>
        </div>

        <div class="scroll-container">
            <div class="list-group">
                @foreach($categories as $category)
                    <div class="list-group-item p-3 position-relative category-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('categories.show', $category->id) }}" class="text-decoration-none text-primary fw-bold">
                                {{ $category->id }}. {{ $category->name }}
                            </a>
                            <div class="btn-group">
                                <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-outline-primary me-2">View</a>
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-info me-2">Edit</a>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-outline-danger delete-button">Delete</button>
                                </form>
                            </div>
                        </div>

                        <!-- Hover effect: categories Details -->
                        <div class="category-details card position-absolute end-50 translate-middle d-none p-3 mt-2 shadow-lg">
                            <div>Category ID: {{ $category->id }}</div>
                            <div>Description: {{ $category->description ?? 'No Description Provided' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .scroll-container {
                max-height: 75vh;
                overflow-y: auto;
                border: 1px solid #ccc;
                border-radius: 8px;
                background-color: #fff;
            }

            .category-item {
                position: relative;
                cursor: pointer;
            }

            .category-item:hover .category-details {
                display: block !important;
                opacity: 1 !important;
            }

            .category-details {
                display: none;
                opacity: 0;
                transform: translate(-40%, -40%) scale(0.8);
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 8px;
                width: 250px;
                z-index: 10;
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Auto-hide success alert after 2 seconds
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 500);
                }
            }, 2000);

            // Confirm before delete
            document.addEventListener('DOMContentLoaded', () => {
                const deleteButtons = document.querySelectorAll('.delete-button');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function(event) {
                        const confirmed = confirm('Are you sure you want to delete this categories?');
                        if (!confirmed) {
                            event.preventDefault();
                        }
                    });
                });
            });
        </script>
    @endpush
</x-layout>
