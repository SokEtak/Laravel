<x-layout title="Show Product">
    <div class="container mt-5">
        <h1 class="mb-4">Product Details</h1>

        {{-- Update Product Form --}}
        <form method="POST" action="{{ route('products.update', $product) }}">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    <h2 ondblclick="editField('product-name')">
                        <span id="product-name-text">{{ $product->name }}</span>
                        <input type="text" name="name" id="product-name-input" value="{{ $product->name }}" class="form-control d-none">
                    </h2>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="h5">Price:</label>
                        <span id="price-text" ondblclick="editField('price')">${{ number_format($product->price, 2) }}</span>
                        <input type="number" step="0.01" name="price" id="price-input" value="{{ $product->price }}" class="form-control d-none">
                    </div>

                    <div class="mb-3">
                        <label class="h5">Quantity:</label>
                        <span id="qty-text" ondblclick="editField('qty')">{{ $product->qty }}</span>
                        <input type="number" name="qty" id="qty-input" value="{{ $product->qty }}" class="form-control d-none">
                    </div>

                    <div class="mb-3">
                        <label class="h5">Description:</label>
                        <p id="description-text" ondblclick="editField('description')">{{ $product->description }}</p>
                        <textarea name="description" id="description-input" class="form-control d-none">{{ $product->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="h5">Category:</label>
                        <div id="category-text" ondblclick="editField('categories')">
                            @if ($product->category)
                                ID: {{ $product->category->id }}<br>
                                Name: <span id="category-name-text">{{ $product->category->name }}</span>
                            @else
                                <p class="text-muted fst-italic">No category assigned</p>
                            @endif
                        </div>
                        <input type="text" name="category" id="category-input" value="{{ $product->category ? $product->category->name : '' }}" class="form-control d-none">
                    </div>

                </div>

                <div class="card-footer d-flex justify-content-start gap-1">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Product List</a>

                    {{-- Fix: Button inside form for saving changes --}}
                    <button type="submit" class="btn btn-success">Save Change</button>
                </div>
            </div>
        </form>

        {{-- Delete Product Form --}}
        <form method="POST" action="{{ route('products.destroy', $product) }}" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Product</button>
        </form>
    </div>

    @push('scripts')
        <script>
            let escapeCount = 0;
            let escapeTimer;

            // Function to handle editing of fields
            function editField(field) {
                const textEl = document.getElementById(field + '-text');
                const inputEl = document.getElementById(field + '-input');

                if (!textEl || !inputEl) return;

                // Hide the text and show the input field
                textEl.classList.add('d-none');
                inputEl.classList.remove('d-none');
                inputEl.focus();

                // Key down event handler for Escape and other key actions
                function handleKeyDown(e) {
                    if (e.key === 'Escape') {
                        escapeCount++;

                        if (escapeCount === 1) {
                            // Hide only the current field
                            inputEl.classList.add('d-none');
                            textEl.classList.remove('d-none');
                        }

                        if (escapeCount === 2) {
                            // Double escape = reset all editable fields
                            const inputs = document.querySelectorAll('input, textarea');
                            const spans = document.querySelectorAll('span[id$="-text"], p[id$="-text"]');

                            // Hide all inputs and show all text
                            inputs.forEach(el => el.classList.add('d-none'));
                            spans.forEach(el => el.classList.remove('d-none'));

                            // Reset escape counter
                            escapeCount = 0;
                            clearTimeout(escapeTimer);
                        }

                        // Reset counter if no second press in 1s
                        clearTimeout(escapeTimer);
                        escapeTimer = setTimeout(() => {
                            escapeCount = 0;
                        }, 1000);
                    }
                }

                inputEl.addEventListener('keydown', handleKeyDown);
            }
        </script>
    @endpush
</x-layout>
