<x-layout title="Product List">
    <div class="container mt-5">
        @include('components.alerts.success')

        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">

            @if(isset($products) && count($products))
                <h2 class="mb-0">Product List ({{ count($products) }})</h2>
            @else
                <h2 class="mb-0">No products available.</h2>
            @endif

            <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
        </div>

        {{--category tabs--}}
        @if(isset($categories) && count($categories))
            {{-- Replaced with nav-pills style --}}
            <ul class="nav nav-pills mb-3">
                {{-- "All Products" tab --}}
                <li class="nav-item">
                    <a class="nav-link @if(!request('category')) active @endif"
                       aria-current="page"
                       href="{{ route('products.index') }}">
                        All Products
                    </a>
                </li>
                @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link @if(request('category') == $category->id) active @endif"
                           href="{{ route('products.index', ['category' => $category->id]) }}">
                            {{ $category->category_name ?? "No Name" }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- DARK THEMED CARD ONLY --}}
        <div class="card shadow rounded-4 border-0 scroll-container p-4 bg-dark text-white">
            <div class="list-group list-group-flush">
                @foreach($products as $product)
                    <div class="list-group-item p-3 position-relative product-item border-0 shadow-sm rounded-3 mb-3" style="background-color: #343a40; color: #fff;">
                        <div class="d-flex justify-content-between align-items-center">
                            {{-- Added product ID display --}}
                            <span class="text-blue-100">ID: {{ $product['id'] }}</span>
                            <a href="{{ route('products.show', $product['id']) }}" class="text-decoration-none text-primary fw-semibold fs-5">
                                {{ $product['product_name'] }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .product-item:hover {
                background-color: #3c434c; /* Slightly lighter than #343a40 */
            }

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

            /*!* Custom styles for nav-pills *!*/
            /*.nav-pills .nav-link {*/
            /*    color: #d71212; !* Default text color for inactive tabs *!*/
            /*}*/

            /*.nav-pills .nav-link.active,*/
            /*.nav-pills .show > .nav-link {*/
            /*    background-color: #0d6efd; !* Blue background for active tab *!*/
            /*    color: #ffffff; !* White text for active tab *!*/
            /*}*/

            /*.nav-pills .nav-link:hover {*/
            /*    background-color: #495057; !* Slightly darker on hover for inactive tabs *!*/
            /*    color: #ffffff;*/
            /*}*/
        </style>
    @endpush
</x-layout>
