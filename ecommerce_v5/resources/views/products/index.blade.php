<x-layout title="Product List">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Product List ({{ $products->count() }})</h2>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
        </div>

            @include('components.alerts.success', ['bgClass' => 'text-bg-success', 'icon' => 'bi bi-box-seam'])

        {{-- Category Filter Dropdown --}}
        @if(isset($categories) && $categories->count())
            <form method="GET" action="{{ route('products.index') }}" class="mb-4">
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <label for="category" class="col-form-label text-white">Filter by Category:</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select bg-dark text-white border-secondary" id="category" name="category" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name ?? 'Unnamed' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        @endif

        {{-- Table View --}}
        @if ($products->isEmpty())
            <div class="alert alert-info" role="alert">
                No product records found.
            </div>
        @else
            <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Category</th>
                            <th scope="col">Created</th>
                            <th scope="col">Updated</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <a href="{{ route('products.show', $product->id) }}"
                                       class="text-info text-decoration-none">
                                        {{ $product->product_name }}
                                    </a>
                                </td>
                                <td class="text-success">${{ number_format($product->price, 2) }}</td>
                                <td>
                                    <a href="{{route('categories.show',$product->category->id)}}" class="text-info text-decoration-none">
                                        {{ $product->category->category_name ?? 'Uncategorized' }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($product->created_at)->timezone('Asia/Phnom_Penh')->diffForHumans() }}</td>
                                <td>{{ \Carbon\Carbon::parse($product->updated_at)->timezone('Asia/Phnom_Penh')->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info me-1">View</a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
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
