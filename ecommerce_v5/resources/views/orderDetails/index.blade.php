<x-layout title="Order Details List">

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

    <div class="container mt-5">
        @include('components.alerts.success')

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">List of Orders ({{ count($orderDetails) }})</h2>
            <a href="{{ route('orderDetails.create') }}" class="btn btn-primary">Add Order</a>
        </div>

        <div class="card shadow rounded-4 border-0 scroll-container p-4 bg-dark text-white">
            <div class="list-group list-group-flush">
                @forelse($orderDetails as $order)
                    @php
                        $created = \Carbon\Carbon::parse($order['created_at'])->timezone('Asia/Phnom_Penh');
                        $updated = \Carbon\Carbon::parse($order['updated_at'])->timezone('Asia/Phnom_Penh');
                    @endphp

                    <div class="list-group-item p-3 position-relative border-0 shadow-sm rounded-3 mb-3"
                         style="background-color: #343a40;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">
                                <a href="{{ route('orderDetails.show', $order['id']) }}" class="text-decoration-none text-info">
                                    Order ID#{{$order['id']}}
                                </a>
                            </h5>
                            <span class="badge bg-info total-badge fs-5 px-2 py-1">
                                Total: ${{ number_format($order['total'], 2) }}
                            </span>
                        </div>

                        <div class="mt-2">
                            <div>
                                <strong style="color:#e5dcdc">Created:</strong>
                                <span style="color: #ddd;">
                                    {{ formatTimeDiff($created, $now) }}
                                </span>
                            </div>
                            <div>
                                <strong style="color:#e5dcdc">Updated:</strong>
                                <span style="color: #ddd;">
                                    {{ formatTimeDiff($updated, $now) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No orders found.</p>
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
            .total-badge {
                font-size: 1.25rem; /* bigger font */
                font-weight: 700;   /* bolder */
                padding: 0.5rem 0.75rem;
            }
        </style>
    @endpush
</x-layout>