<x-layout title="Payment List">
    <div class="container my-5">
        {{-- Success Alert --}}
        @include('components.alerts.success', ['bgClass' => 'text-bg-success', 'icon' => 'bi bi-credit-card'])

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Payment List ({{ count($payments) }})</h2>
        </div>

        @if(empty($payments) || count($payments) === 0)
            <div class="alert alert-info" role="alert">
                No payments available.
            </div>
        @else
            <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td><a href="{{ route('orderDetails.show', $payment->order_id) }}"
                                       class="text-info text-decoration-none">#{{ $payment->order_id }}</a></td>
                                <td class="text-success">${{ number_format($payment->amount, 2) }}</td>
                                <td>
                                    @if ($payment->status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif ($payment->status === 'unpaid')
                                        <span class="badge bg-warning text-dark">Unpaid</span>
                                    @else
                                        <span class="badge bg-secondary">unknown</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($payment->created_at)->timezone('Asia/Phnom_Penh')->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    <a href="{{ route('payments.show', $payment->id) }}"
                                       class="btn btn-sm btn-info me-1">View</a>
                                    <a href="{{ route('payments.edit', $payment->id) }}"
                                       class="btn btn-sm btn-warning me-1">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    @push('styles')
        <style>
            .table td, .table th {
                vertical-align: middle;
            }
        </style>
    @endpush
</x-layout>
