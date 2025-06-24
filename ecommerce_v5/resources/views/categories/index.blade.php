<x-layout title="Category List">
    <div class="container my-5">
        {{-- Alerts --}}
         @include('components.alerts.success', ['bgClass' => 'text-bg-success', 'icon' => 'bi bi-tags'])

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Category List ({{ $categories->count() }})</h2>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>
        </div>

        @if ($categories->isEmpty())
            <div class="alert alert-info" role="alert">
                No category records found.
            </div>
        @else
            <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <a href="{{ route('categories.show', $category->id) }}" class="text-info text-decoration-none">
                                        {{ $category->category_name }}
                                    </a>
                                </td>
                                <td>{{ $category->category_description }}</td>
                                <td>
                                    <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-info me-1">View</a>
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-layout>
