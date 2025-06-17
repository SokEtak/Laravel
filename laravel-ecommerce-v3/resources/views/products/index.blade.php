<x-layout title="Product List">
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mb-5" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container mt-5">
{{--        <a href="{{ route('app.download') }}" class="btn btn-info mb-4">Download The Document</a>--}}

        <div class="d-flex justify-content-between align-items-center mb-4">
           @if(isset($products) && count($products))
                <h2 class="mb-0">Product List ({{ count($products) }})</h2>
            @else
                <h2 class="mb-0">No products available or failed to load.</h2>
            @endif
            <a href="{{ route('products.create') }}" class="btn btn-primary">បន្ថែមទំនិញ</a>
        </div>

        <div class="card shadow rounded-4 border-0 scroll-container p-4">
            <div class="list-group list-group-flush">
                @foreach($products as $product)
                    <div class="list-group-item p-3 position-relative product-item border-0 shadow-sm rounded-3 mb-3 bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('products.show', $product['id']) }}" class="text-decoration-none text-primary fw-semibold fs-5">
                                {{ $product['product_name']}}
                            </a>

{{--                            <div class="btn-group">--}}
{{--                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">View</a>--}}
{{--                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-info me-2">Edit</a>--}}
{{--                                <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">--}}
{{--                                    @csrf--}}
{{--                                    @method('delete')--}}
{{--                                    <button type="submit" class="btn btn-sm btn-outline-danger delete-button">Delete</button>--}}
{{--                                </form>--}}
{{--                            </div>--}}
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
                    background-color: transparent;
                }

                .product-item {
                    position: relative;
                    cursor: pointer;
                    transition: background 0.3s ease;
                }

                .product-item:hover {
                    background-color: #f8f9fa;
                }
            </style>
        @endpush

    @push('scripts')
        <script>
            // Auto-hide success alert
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 500);
                }
            }, 2000);
        </script>
    @endpush
</x-layout>
