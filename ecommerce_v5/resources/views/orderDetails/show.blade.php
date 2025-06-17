<x-layout title="Order Detail #{{ $orderDetail['id'] }}">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 text-white">Order Detail #{{ $orderDetail['id'] }}</h2>
            <div>
                <a href="{{ route('orderDetails.index') }}" class="btn btn-outline-light">← Back to List</a>
                <a href="{{ route('orderDetails.edit', $orderDetail['id']) }}" class="btn btn-outline-warning">Edit</a>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        Delete
                </button>
                {{-- delete confirmation --}}
                <x-alerts.delete_confirmation
                    id="deleteModal"
                    :action="route('orderDetails.destroy', $orderDetail['id'])"
                    title="Delete Category"
                    body="Are you sure you want to delete the order #'{{ $orderDetail['id'] }}'?"
                />
            </div>
        </div>

        <div class="card shadow-sm border-secondary rounded-4 p-4" style="background-color: #343a40">
            <div class="mb-4">
                <h5 class="fw-bold text-info">Order Information</h5>

                @php
                    $orderCreated = \Carbon\Carbon::parse($orderDetail['created_at'])->timezone('Asia/Phnom_Penh');
                    $orderUpdated = \Carbon\Carbon::parse($orderDetail['updated_at'])->timezone('Asia/Phnom_Penh');
                @endphp

                <div class="d-flex justify-content-between align-items-center text-white mb-2">
                    <p class="mb-0"><strong>User ID:</strong> {{ $orderDetail['user_id'] }} <span class="text-info">(ordered by: {{ $orderDetail['user']['name'] ?? 'N/A' }})</span></p>
                    <p class="mb-0"><strong>Created At:</strong> {{ $orderCreated->format('Y-m-d H:i:s') }}</p>
                </div>
                <div class="d-flex justify-content-between align-items-center text-white">
                    <p class="mb-0"><strong>Order Total:</strong> <span class="fs-4 fw-bold text-warning">${{ number_format($orderDetail['total'], 2) }}</span></p>
                    <p class="mb-0"><strong>Last Updated:</strong> {{ $orderUpdated->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>

            <hr class="my-4 border-secondary">

            <div>
                <h5 class="fw-bold mb-3 text-info">Items</h5>

                @php $grandTotalCalculated = 0; $i = 0; @endphp

                @if (!empty($orderDetail['items']) && count($orderDetail['items']) > 0)
                    <div class="table-responsive">
                        <table class="table table-dark table-bordered align-middle text-white">
                            <thead class="table-secondary text-dark">
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Original Price</th>
                                <th>Discount (%)</th>
                                <th>Quantity</th>
                                <th>Subtotal (after discount)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orderDetail['items'] as $item)
                                @php
                                    $i++;
                                    $originalPrice = $item['product']['price'] ?? 0;
                                    $discountPercent = 0;
                                    if (isset($item['product']['discount']) && $item['product']['discount']['active'] == 1) {
                                        $discountPercent = $item['product']['discount']['discount_percent'] ?? 0;
                                    }
                                    $discountedPrice = $originalPrice * (1 - ($discountPercent / 100));
                                    $itemSubtotal = $discountedPrice * $item['quantity'];
                                    $grandTotalCalculated += $itemSubtotal;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $item['product']['product_name'] ?? 'N/A' }}</td>
                                    <td>${{ number_format($originalPrice, 2) }}</td>
                                    <td>{{ number_format($discountPercent, 2) }}%</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>${{ number_format($itemSubtotal, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr class="table-secondary text-dark">
                                <th colspan="5" class="text-end">Calculated Grand Total:</th>
                                <th>${{ number_format($grandTotalCalculated, 2) }}</th>
                            </tr>
                            <tr class="table-secondary text-dark">
                                <th colspan="5" class="text-end">Stored Order Total:</th>
                                <th>${{ number_format($orderDetail['total'], 2) }}</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if(abs($orderDetail['total'] - $grandTotalCalculated) > 0.01)
                        <div class="alert alert-warning text-dark">
                            <strong>Warning:</strong> The stored order total (${{ number_format($orderDetail['total'], 2) }}) does not match the calculated grand total (${{ number_format($grandTotalCalculated, 2) }}) based on current product prices and discounts. This might indicate price changes or manual adjustments.
                        </div>
                    @endif

                @else
                    <p class="text-muted">No items found for this order.</p>

                    @if(($orderDetail['total'] ?? 0) > 0 || ($orderDetail['paymentDetail']['amount'] ?? 0) > 0)
                        <div class="card mt-4 border-warning shadow-sm rounded-4 p-3 bg-dark text-warning">
                            <strong>Note:</strong> This order has a total or payment amount but no associated items.<br>
                            <em>Item(s) might have been deleted.</em>
                        </div>
                    @endif
                @endif
            </div>

            <hr class="my-4 border-secondary">

            <div>
                <h5 class="fw-bold mb-3 text-info">Payment Information</h5>
                @if ($orderDetail['paymentDetail'])
                    <div class="d-flex justify-content-between align-items-center text-white mb-2">
                        <p class="mb-0"><strong>Payment ID:</strong> {{ ucfirst($orderDetail['paymentDetail']['id']) }}</p>
                        @php
                            $paymentCreated = \Carbon\Carbon::parse($orderDetail['paymentDetail']['created_at'])->timezone('Asia/Phnom_Penh');
                        @endphp
                        <p class="mb-0"><strong>Created At:</strong> {{ $paymentCreated->format('Y-m-d H:i:s') }}</p>
                    </div>

                    <p class="text-white"><strong>Provider:</strong> {{ ucfirst($orderDetail['paymentDetail']['provider']) }}</p>
                    <div class="d-flex justify-content-between align-items-center text-white mb-2">
                        <p class="mb-0"><strong>Amount Paid:</strong> ${{ number_format($orderDetail['paymentDetail']['amount'], 2) }}</p>
                        @php
                            $paymentUpdated = \Carbon\Carbon::parse($orderDetail['paymentDetail']['updated_at'])->timezone('Asia/Phnom_Penh');
                        @endphp
                        <p class="mb-0"><strong>Last Updated:</strong> {{ $paymentUpdated->format('Y-m-d H:i:s') }}</p>
                    </div>

                    <p class="text-white"><strong>Status:</strong>
                        <span class="badge {{ $orderDetail['paymentDetail']['status'] == 'paid' ? 'bg-success' : ($orderDetail['paymentDetail']['status'] == 'unpaid' ? 'bg-danger' : 'bg-warning text-dark') }}">
                            {{ ucfirst($orderDetail['paymentDetail']['status']) }}
                        </span>
                    </p>
                    @if ($orderDetail['paymentDetail']['provider'] == 'bank' && $orderDetail['paymentDetail']['bank_detail'])
                        <p class="text-white"><strong>Bank Detail:</strong> {{ $orderDetail['paymentDetail']['bank_detail'] }}</p>
                    @endif
                @else
                    <p class="text-muted">No payment information found for this order.</p>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            body {
                background-color: #121212;
            }
            .card {
                background-color: #343a40;
            }
            .text-white {
                color: #f8f9fa !important;
            }
            .text-info {
                color: #17a2b8 !important;
            }
            .text-warning {
                color: #ffc107 !important;
            }
            .table-dark th,
            .table-dark td {
                vertical-align: middle;
            }
            .table-secondary th {
                background-color: #6c757d;
                color: #343a40 !important;
            }
            .alert-warning {
                background-color: #ffc107;
                border-color: #ffc107;
            }
        </style>
    @endpush
</x-layout>
