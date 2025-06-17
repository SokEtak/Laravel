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
        @include('components.alerts.success')

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">List of Order Items ({{ count($orderItems) }})</h2>
{{--            <a href="{{ route('orderItems.create') }}" class="btn btn-primary">Add Order Item</a>--}}
        </div>

        <div class="card shadow rounded-4 border-0 scroll-container p-4 bg-dark text-white">
            <div class="list-group list-group-flush">
                @forelse($orderItems as $item)
                    @php
                        $created = \Carbon\Carbon::parse($item['created_at'])->timezone('Asia/Phnom_Penh');
                        $updated = \Carbon\Carbon::parse($item['updated_at'])->timezone('Asia/Phnom_Penh');
                    @endphp

                    <div class="list-group-item p-3 border-0 shadow-sm rounded-3 mb-3" style="background-color: #343a40;">
                        <h5 class="fw-bold mb-2 text-info">
                            Product: {{ $item['product']['product_name'] ?? 'N/A' }}
                        </h5>

                        <div><strong style="color:#e5dcdc">Order ID:</strong> <span style="color: #ddd;">{{ $item['order_id'] }}</span></div>
                        <div><strong style="color:#e5dcdc">Quantity:</strong> <span style="color: #ddd;">{{ $item['quantity'] }}</span></div>
                        <div><strong style="color:#e5dcdc">Unit Price:</strong> <span style="color: #ddd;">${{ number_format($item['product']['price'] ?? 0, 2) }}</span></div>
                        <div><strong style="color:#e5dcdc">Total:</strong> <span style="color: #ddd;">${{ number_format(($item['product']['price'] ?? 0) * $item['quantity'], 2) }}</span></div>

                        <div class="small mt-2">
                            <div><strong style="color: #ffcc00;">Created:</strong> <span style="color: #ddd;">{{ $created->format('Y-m-d H:i') }} <small style="color: #bbb;">({{ formatTimeDiff($created, $now) }})</small></span></div>
                            <div><strong style="color: #ff6633;">Updated:</strong> <span style="color: #ddd;">{{ $updated->format('Y-m-d H:i') }} <small style="color: #bbb;">({{ formatTimeDiff($updated, $now) }})</small></span></div>
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
