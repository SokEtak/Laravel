<x-layout title="Order Items List">
   @php
    $now = \Carbon\Carbon::now('Asia/Phnom_Penh');

    function formatTimeDiff($time, $now) {
        $minutes = (int) $time->diffInMinutes($now);
        $hours = (int) $time->diffInHours($now);
        $days = (int) $time->diffInDays($now);

        if ($minutes === 0) {
            return 'a few seconds ago';
        } elseif ($minutes < 60) {
            return $minutes . ' minute' . ($minutes === 1 ? '' : 's') . ' ago';
        } elseif ($hours < 24) {
            return $hours . ' hour' . ($hours === 1 ? '' : 's') . ' ago';
        } else {
            return $days . ' day' . ($days === 1 ? '' : 's') . ' ago';
        }
    }
    @endphp

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">List of Order Items ({{ count($orderItems) }})</h2>
        </div>

        <div class="card shadow rounded-4 border-0 scroll-container p-4 bg-dark text-white">
            <div class="row g-4">
                @forelse($orderItems as $item)
                    @php
                        $created = \Carbon\Carbon::parse($item['created_at'])->timezone('Asia/Phnom_Penh');
                    @endphp

                    <div class="col-lg-3 col-md-6">
                        <div class="list-group-item p-3 border-0 shadow-sm rounded-3 h-100"
                             style="background-color: #343a40;">
                            <h5 class="fw-bold mb-2 text-white">
                                Product:
                                <a href="{{ route('products.show',  $item['product']['id']) }}"
                                   class="text-info text-decoration-none">
                                    {{ $item['product']['product_name'] ?? 'N/A' }}
                                </a>
                            </h5>

                            <div><strong style="color:#e5dcdc">Order ID:</strong>
                                <span style="color: #ddd;">
                                    <a
                                        href="{{ route('orderDetails.show', $item['order_id']) }}"
                                        class="text-info text-decoration-none">#{{ $item['order_id'] }}
                                    </a>
                                </span>
                            </div>

                            <div><strong style="color:#e5dcdc">Quantity:</strong> <span
                                    style="color: #ddd;">{{ $item['quantity'] }}</span></div>
                            <div><strong style="color:#e5dcdc">Unit Price:</strong> <span
                                    style="color: #ddd;">${{ number_format($item['product']['price'] ?? 0, 2) }}</span>
                            </div>
                            <div><strong style="color:#e5dcdc">Total:</strong> <span
                                    style="color: #ddd;">${{ number_format(($item['product']['price'] ?? 0) * $item['quantity'], 2) }}</span>
                            </div>

                            <div class="small ">
                                <div><strong style="color: #ffcc00;">Order Date:</strong> <span style="color: #ddd;">{{ $created->format('Y-m-d') }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No order items found.</p>
                @endforelse
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .scroll-container {
                max-height: 75vh;
                overflow-y: auto;
            }
        </style>
    @endpush
</x-layout>
