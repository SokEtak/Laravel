<x-layout title="Payment List">
    <div class="container mt-5">
        @include('components.alerts.success')

        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            @if(isset($payments) && count($payments))
                <h2 class="mb-0">Payment List ({{ count($payments) }})</h2>
            @else
                <h2 class="mb-0">No payments available.</h2>
            @endif

{{--            <a href="{{ route('payments.create') }}" class="btn btn-primary">Add Payment</a>--}}
        </div>

        {{-- DARK THEMED CARD ONLY --}}
        <div class="card shadow rounded-4 border-0 scroll-container p-4 bg-dark text-white">
            <div class="list-group list-group-flush">
                @foreach($payments as $payment)
                    <div class="list-group-item p-3 position-relative payment-item border-0 shadow-sm rounded-3 mb-3" style="background-color: #343a40; color: #fff;">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('payments.show', $payment['id']) }}" class="text-decoration-none text-primary fw-semibold fs-5">
                                Order #{{ $payment['order_id'] }} — {{ ucfirst($payment['status']) }} — ${{ number_format($payment['amount'], 2) }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .payment-item:hover {
                background-color: #3c434c; /* Slightly lighter than #343a40 */
            }

            .scroll-container {
                max-height: 75vh;
                overflow-y: auto;
                background-color: transparent;
            }

            .payment-item {
                position: relative;
                cursor: pointer;
                transition: background 0.3s ease;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
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
