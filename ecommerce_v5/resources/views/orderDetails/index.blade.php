<x-layout title="Order Details List">
    <div class="container my-5">
        {{-- Success Alert --}}
        @include('components.alerts.success', ['bgClass' => 'text-bg-success', 'icon' => 'bi bi-receipt'])

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Order List ({{ $orderDetails->count() }})</h2>
            <a href="{{ route('orderDetails.create') }}" class="btn btn-primary">Add Order</a>
        </div>

        @if ($orderDetails->isEmpty())
            <div class="alert alert-info" role="alert">
                No order records found.
            </div>
        @else
            <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Total</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orderDetails as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td class="text-success">${{ number_format($order->total, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->timezone('Asia/Phnom_Penh')->format('Y-m-d H:i:s') }}</td>
                                <td><a href="{{ route('users.show', $order->user->id) }}"
                                       class="text-info text-decoration-none">{{ $order->user->name ?? 'Unknown' }}</a>
                                </td>
                                <td>
                                    @if($order->paymentDetail->status == 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($order->paymentDetail->status == 'unpaid')
                                        <span class="badge bg-warning text-dark">Unpaid</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('orderDetails.show', $order->id) }}"
                                       class="btn btn-sm btn-info me-1">View</a>
                                    <a href="{{ route('orderDetails.edit', $order->id) }}"
                                       class="btn btn-sm btn-warning me-1">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteOrderModal{{ $order->id }}">
                                        Delete
                                    </button>
                                    {{-- delete-confirmation --}}
                                    <x-alerts.delete_confirmation
                                        id="deleteOrderModal{{ $order->id }}"
                                        :action="route('orderDetails.destroy', $order->id)"
                                        title="Delete Order"
                                        body="Are you sure you want to delete this order?"
                                    />

                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        @endif
    </div>
</x-layout>
