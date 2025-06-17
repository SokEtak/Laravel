<x-layout title="Category List">
    {{-- Flash message --}}
    <div class="container mt-5">
        @include('components.alerts.success')

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">List of Categories ({{ count($categories) }})</h2>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>
        </div>

        {{-- Dark themed card container --}}
        <div class="card shadow rounded-4 border-0 scroll-container p-4 bg-dark text-white">
            <div class="list-group list-group-flush">
                @foreach($categories as $category)
                    <div class="list-group-item p-3 position-relative border-0 shadow-sm rounded-3 mb-3" style="background-color: #343a40; color: #ffffff;">
                    <h5 class="fw-bold mb-2">
                            <a href="{{ route('categories.show', $category['id']) }}" class="text-decoration-none text-primary">
                                {{ $category['category_name'] }}
                            </a>
                        </h5>
                        <div><strong>ID:</strong> {{ $category['id'] }}</div>
                        <div><strong>Description:</strong> {{ $category['category_description'] }}</div>
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
            }

            .list-group-item:hover {
                background-color: #3c434c;
            }

        </style>
    @endpush
</x-layout>
