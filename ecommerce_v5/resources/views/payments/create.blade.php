{{--<x-layout title="Add New Payment">--}}
{{--    <div class="container mt-5">--}}
{{--        <div class="card border-0 shadow-sm rounded-4 px-4 py-3" style="background-color: #427fac;">--}}
{{--            <div class="card-header border-0 bg-white px-0 pb-0">--}}
{{--                <h3 class="fw-semibold">Create New Payment</h3>--}}
{{--                <p class="text-muted">Fill in the payment details below.</p>--}}
{{--            </div>--}}

{{--            <div class="card-body px-0">--}}
{{--                <form action="{{ route('payments.store') }}" method="POST">--}}
{{--                    @csrf--}}

{{--                    <div class="row g-4">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <label for="order_id" class="form-label fw-semibold">Order</label>--}}
{{--                            <select name="order_id" id="order_id" class="form-select form-select-lg rounded-3" required>--}}
{{--                                <option value="">Select Order</option>--}}
{{--                                @foreach ($orders as $order)--}}
{{--                                    <option value="{{ $order->id }}" data-total="{{ $order->total }}"--}}
{{--                                        {{ old('order_id') == $order->id ? 'selected' : '' }}>--}}
{{--                                        Order #{{ $order->id }} - Total: ${{ $order->total }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('order_id') <small class="text-danger">{{ $message }}</small> @enderror--}}
{{--                        </div>--}}

{{--                        <div class="col-md-6">--}}
{{--                            <label for="amount" class="form-label fw-semibold">Amount ($)</label>--}}
{{--                            <input type="number" name="amount" step="0.01" class="form-control form-control-lg rounded-3" value="{{ old('amount') }}" required>--}}
{{--                            @error('amount') <small class="text-danger">{{ $message }}</small> @enderror--}}
{{--                        </div>--}}

{{--                        <div class="col-md-6">--}}
{{--                            <label for="provider" class="form-label fw-semibold">Provider</label>--}}
{{--                            <input type="text" name="provider" class="form-control form-control-lg rounded-3" value="{{ old('provider') }}" required>--}}
{{--                            @error('provider') <small class="text-danger">{{ $message }}</small> @enderror--}}
{{--                        </div>--}}

{{--                        <div class="col-md-6">--}}
{{--                            <label for="status" class="form-label fw-semibold">Status</label>--}}
{{--                            <select name="status" class="form-select form-select-lg rounded-3" required>--}}
{{--                                <option value="">Select Status</option>--}}
{{--                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>--}}
{{--                                <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>--}}
{{--                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>--}}
{{--                            </select>--}}
{{--                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror--}}
{{--                        </div>--}}

{{--                        <div class="col-12 text-end">--}}
{{--                            <button type="submit" class="btn btn-dark btn-lg px-4 rounded-3">Create Payment</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    @push('scripts')--}}
{{--        <script>--}}
{{--            document.addEventListener('DOMContentLoaded', function () {--}}
{{--                const orderSelect = document.getElementById('order_id');--}}
{{--                const amountInput = document.querySelector('input[name="amount"]');--}}

{{--                orderSelect.addEventListener('change', function () {--}}
{{--                    const selected = this.options[this.selectedIndex];--}}
{{--                    const total = selected.getAttribute('data-total');--}}
{{--                    amountInput.value = total ? total : '';--}}
{{--                });--}}
{{--            });--}}
{{--        </script>--}}
{{--    @endpush--}}
{{--</x-layout>--}}
