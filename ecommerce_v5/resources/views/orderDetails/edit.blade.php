<x-layout title="Edit Order #{{ $orderDetail['id'] }}">
    {{-- Display all validation errors at the top of the form --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('orderDetails.index') }}" class="btn btn-outline-light">← Back to List</a>
        </div>

        <form action="{{ route('orderDetails.update', $orderDetail['id']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card shadow-sm border-secondary rounded-4 p-4" style="background-color: #343a40">
                <h2 class="mb-0 text-white">Edit Order #{{ $orderDetail['id'] }}</h2>
                <p class="text-light">Modify the order details below.</p>

                <hr class="my-4 text-light">

                {{-- User and Total --}}
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label for="user_id" class="form-label text-info fw-bold">User</label>
                        <select name="user_id" id="user_id" class="form-select bg-dark text-white border-secondary">
                            @foreach ($users as $user)
                                <option value="{{ $user['id'] }}" {{ old('user_id', $orderDetail['user_id']) == $user['id'] ? 'selected' : '' }}>
                                    {{ $user['name'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="total" class="form-label text-info fw-bold">Total ($)</label>
                        <input type="number" name="total" id="total" class="form-control bg-dark text-white border-secondary"
                               value="{{ old('total', $orderDetail['total']) }}" step="0.01" readonly>
                        @error('total') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <hr class="my-4 text-light">

                {{-- Order Items --}}
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold text-white">Items</h5>
                    <button type="button" class="btn btn-success btn-sm" id="add-item-btn">+ Add Item</button>
                </div>

                <div id="order-items-container" class="row g-3">
                    @foreach (old('items', $orderDetail['items']) as $index => $item)
                        <div class="order-item col-12 border rounded-3 p-3 mb-3 bg-dark text-white d-flex align-items-center gap-3 flex-wrap">
                            <div class="flex-grow-1">
                                <label class="form-label text-info fw-bold">Product</label>
                                <select name="items[{{ $index }}][product_id]" class="form-select bg-secondary text-white border-secondary product-select" required style="width: 60%;">
                                    <option value="">-- Select --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product['id'] }}"
                                                data-price="{{ $product['price'] }}"
                                                data-discount-active="{{ $product['discount']['active'] ?? 0 }}"
                                                data-discount-percent="{{ $product['discount']['discount_percent'] ?? 0 }}"
                                            {{ (old("items.$index.product_id", $item['product_id'] ?? ($item['product']['id'] ?? null))) == $product['id'] ? 'selected' : '' }}>
                                            {{ $product['product_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error("items.$index.product_id") <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="flex-grow-1">
                                <label class="form-label text-info fw-bold">Price ($)</label>
                                <input type="text" readonly class="form-control bg-secondary text-white border-secondary product-price" value="0.00" style="width: 30%;">
                            </div>
                            <div class="flex-grow-1">
                                <label class="form-label text-info fw-bold">Discount (%)</label>
                                <input type="text" readonly class="form-control bg-secondary text-white border-secondary product-discount" value="0.00" style="width: 30%;">
                            </div>

                            <div class="flex-grow-1">
                                <label class="form-label text-info fw-bold">Quantity</label>
                                <input type="number" name="items[{{ $index }}][quantity]" value="{{ old("items.$index.quantity", $item['quantity']) }}"
                                       class="form-control bg-secondary text-white border-secondary quantity-input" min="1" required style="width: 30%;">
                                @error("items.$index.quantity") <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="flex-grow-1">
                                <label class="form-label text-info fw-bold">Subtotal</label>
                                <input type="text" readonly class="form-control bg-secondary text-white border-secondary subtotal" value="0.00" style="width: 50%;">
                            </div>

                            <div class="col-12 discount-alert text-warning text-sm mt-1" style="display: none;">
                                <i class="fas fa-exclamation-triangle me-1"></i> This product has a discount applied!
                            </div>

                            <button type="button" class="btn btn-outline-danger btn-sm remove-item">Remove</button>
                        </div>
                    @endforeach
                </div>

                <hr class="my-4 text-light">

                {{-- Payment Info --}}
                <h5 class="fw-semibold mb-3 text-white">Payment Info</h5>

                <div class="row g-4">
                    <div class="col-md-3">
                        <label for="provider" class="form-label">Payment Provider</label>
                        <select name="provider" id="provider" class="form-select bg-secondary text-white" required>
                            <option value="">Select</option>
                            <option value="cash" {{ old('provider', $orderDetail['paymentDetail']['provider'] ?? '') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank" {{ old('provider', $orderDetail['paymentDetail']['provider'] ?? '') == 'bank' ? 'selected' : '' }}>Bank</option>
                        </select>
                        @error('provider') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-3 status-container">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select bg-secondary text-white" required>
                            <option value="">Select</option>
                            <option value="paid" {{ old('status', $orderDetail['paymentDetail']['status'] ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ old('status', $orderDetail['paymentDetail']['status'] ?? '') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="pending" {{ old('status', $orderDetail['paymentDetail']['status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-3" id="bank-detail-container" style="{{ old('provider', $orderDetail['paymentDetail']['provider'] ?? '') == 'bank' ? '' : 'display: none;' }}">
                        <label for="bank_detail" class="form-label">Bank Detail</label>
                        <input type="text" name="bank_detail" id="bank_detail"
                               class="form-control bg-secondary text-white"
                               value="{{ old('bank_detail', $orderDetail['paymentDetail']['bank_detail'] ?? '') }}">
                        @error('bank_detail') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="amount" class="form-label">Amount ($)</label>
                        <input type="number" name="amount" id="amount" step="0.01"
                               class="form-control bg-secondary text-white"
                               value="{{ old('amount', $orderDetail['paymentDetail']['amount'] ?? '0.00') }}" readonly>
                        @error('amount') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('orderDetails.edit', $orderDetail['id']) }}" class="btn btn-outline-danger">Cancel</a>
                    <button type="submit" class="btn btn-success ms-2">Update Order</button>
                </div>
            </div>
        </form>
    </div>

    @push('styles')
        <style>
            body {
                background-color: #121212;
            }
            .form-control, .form-select {
                border: 1px solid #6c757d;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const products = @json($products);
                const container = document.getElementById('order-items-container');
                const totalField = document.getElementById('total');
                const addItemBtn = document.getElementById('add-item-btn'); // Corrected ID
                const providerSelect = document.getElementById('provider');
                const bankDetailContainer = document.getElementById('bank-detail-container');
                const amountField = document.getElementById('amount');

                function getProductData(productId) {
                    return products.find(p => p.id == productId);
                }

                function calculateTotal() {
                    let total = 0;

                    container.querySelectorAll('.order-item').forEach(item => {
                        const subtotalInput = item.querySelector('.subtotal');
                        const subtotal = parseFloat(subtotalInput?.value || 0);
                        total += subtotal;
                    });

                    totalField.value = total.toFixed(2);
                    amountField.value = total.toFixed(2); // Keep amount in sync with total
                }

                function calculateItemSubtotal(item) {
                    const productSelect = item.querySelector('.product-select');
                    const quantityInput = item.querySelector('.quantity-input');
                    const subtotalInput = item.querySelector('.subtotal');
                    const productPriceInput = item.querySelector('.product-price');
                    const productDiscountInput = item.querySelector('.product-discount');
                    const discountAlert = item.querySelector('.discount-alert');

                    const productId = productSelect.value;
                    const product = getProductData(productId);

                    let originalPrice = 0;
                    let discountPercent = 0;
                    let hasDiscount = false;

                    if (product) {
                        originalPrice = parseFloat(product.price) || 0;
                        if (product.discount && product.discount.active == 1) {
                            discountPercent = parseFloat(product.discount.discount_percent) || 0;
                            hasDiscount = true;
                        }
                    }

                    productPriceInput.value = originalPrice.toFixed(2);
                    productDiscountInput.value = discountPercent.toFixed(2);

                    if (hasDiscount && discountPercent > 0) {
                        discountAlert.style.display = 'block';
                    } else {
                        discountAlert.style.display = 'none';
                    }

                    const quantity = parseInt(quantityInput.value) || 0;
                    const discountedPrice = originalPrice * (1 - discountPercent / 100);
                    const subtotal = discountedPrice * quantity;

                    subtotalInput.value = subtotal.toFixed(2);
                }

                function updateItemIndexes() {
                    container.querySelectorAll('.order-item').forEach((item, idx) => {
                        item.querySelectorAll('[name^="items["]').forEach(input => {
                            const nameAttr = input.getAttribute('name');
                            // Ensure the name is correctly updated, preventing issues with array indices
                            const newName = nameAttr.replace(/items\[\d+\]/, `items[${idx}]`);
                            input.setAttribute('name', newName);
                        });
                    });
                }

                function bindItemEvents(wrapper) {
                    const select = wrapper.querySelector('.product-select');
                    const qtyInput = wrapper.querySelector('.quantity-input');
                    const removeBtn = wrapper.querySelector('.remove-item');

                    select.addEventListener('change', () => {
                        calculateItemSubtotal(wrapper);
                        calculateTotal();
                    });
                    qtyInput.addEventListener('input', () => {
                        calculateItemSubtotal(wrapper);
                        calculateTotal();
                    });
                    removeBtn.addEventListener('click', () => {
                        wrapper.remove();
                        calculateTotal();
                        updateItemIndexes(); // Re-index items after removal
                    });

                    // Initial subtotal, price, and discount calculation for this item
                    calculateItemSubtotal(wrapper);
                }

                function addItem() {
                    const index = container.querySelectorAll('.order-item').length;

                    const wrapper = document.createElement('div');
                    wrapper.className = 'order-item col-12 border rounded-3 p-3 mb-3 bg-dark text-white d-flex align-items-center gap-3 flex-wrap';

                    wrapper.innerHTML = `
                        <div class="flex-grow-1">
                            <label class="form-label text-info fw-bold">Product</label>
                            <select name="items[${index}][product_id]" class="form-select bg-secondary text-white border-secondary product-select" required style="width: 60%;">
                                <option value="">-- Select --</option>
                                ${products.map(p => `
                                    <option value="${p.id}" data-price="${p.price}"
                                            data-discount-active="${p.discount?.active ?? 0}"
                                            data-discount-percent="${p.discount?.discount_percent ?? 0}">
                                        ${p.product_name}
                                    </option>
                                `).join('')}
                            </select>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label text-info fw-bold">Price ($)</label>
                            <input type="text" readonly class="form-control bg-secondary text-white border-secondary product-price" value="0.00" style="width: 30%;">
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label text-info fw-bold">Discount (%)</label>
                            <input type="text" readonly class="form-control bg-secondary text-white border-secondary product-discount" value="0.00" style="width: 30%;">
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label text-info fw-bold">Quantity</label>
                            <input type="number" name="items[${index}][quantity]" value="1"
                                class="form-control bg-secondary text-white border-secondary quantity-input" min="1" required style="width: 30%;">
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label text-info fw-bold">Subtotal</label>
                            <input type="text" readonly class="form-control bg-secondary text-white border-secondary subtotal" value="0.00" style="width: 50%;">
                        </div>
                        <div class="col-12 discount-alert text-warning text-sm mt-1" style="display: none;">
                            <i class="fas fa-exclamation-triangle me-1"></i> This product has a discount applied!
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-item">Remove</button>
                    `;

                    container.appendChild(wrapper);
                    bindItemEvents(wrapper);
                    calculateTotal();
                }

                // Bind events for existing items (if any are present from old() or initial load)
                container.querySelectorAll('.order-item').forEach(bindItemEvents);

                // Hook up Add Item button
                addItemBtn.addEventListener('click', addItem);

                // Handle payment provider change to show/hide bank detail
                providerSelect.addEventListener('change', function() {
                    if (this.value === 'bank') {
                        bankDetailContainer.style.display = 'block';
                    } else {
                        bankDetailContainer.style.display = 'none';
                    }
                });

                // Initial total and amount calculation when the page loads
                calculateTotal();
            });
        </script>
    @endpush
</x-layout>
