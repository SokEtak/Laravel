<x-layout title="Payment Detail">
    @php
        $now = \Carbon\Carbon::now('Asia/Phnom_Penh');

        function formatTimeDiff($time, $now) {
            $diff = intval($time->diffInMinutes($now));
            if ($diff < 60) return $diff . ' minute' . ($diff === 1 ? '' : 's') . ' ago';
            $diff = intval($time->diffInHours($now));
            if ($diff < 24) return $diff . ' hour' . ($diff === 1 ? '' : 's') . ' ago';
            $diff = intval($time->diffInDays($now));
            return $diff . ' day' . ($diff === 1 ? '' : 's') . ' ago';
        }

        $created = \Carbon\Carbon::parse($payment->created_at)->timezone('Asia/Phnom_Penh');
        $updated = \Carbon\Carbon::parse($payment->updated_at)->timezone('Asia/Phnom_Penh');
    @endphp

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 text-white" style="background-color: #2a2d33;">
            <h2 class="mb-4 text-white text-center">Payment #{{ $payment->id }}</h2>

            <!-- Row 1: Order ID, Amount, Provider -->
            <div class="row mb-3">
                <div class="col-md-4"><strong>Order ID:</strong> {{ $payment->order_id }}</div>
                <div class="col-md-4"><strong>Amount:</strong> ${{ number_format($payment->amount, 2) }}</div>
                <div class="col-md-4"><strong>Provider:</strong> {{ ucfirst($payment->provider) }}</div>
            </div>

            <!-- Row 2: Status, Created At, Updated At -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Status:</strong>
                    <span class="{{ $payment->status === 'paid' ? 'text-success' : ($payment->status === 'unpaid' ? 'text-danger' : 'text-warning') }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </div>
                <div class="col-md-4">
                    <strong>Created At:</strong>
                    {{ $created->format('Y-m-d H:i') }}
                    <small class="text-white">({{ formatTimeDiff($created, $now) }})</small>
                </div>
                <div class="col-md-4">
                    <strong>Updated At:</strong>
                    {{ $updated->format('Y-m-d H:i') }}
                    <small class="text-white">({{ formatTimeDiff($updated, $now) }})</small>
                </div>
            </div>

            <!-- Row 3: Bank Detail -->
            @if ($payment->provider === 'bank' && $payment->bank_detail)
                <div class="row mb-3">
                    <div class="col-12"><strong>Bank Detail:</strong> {{ $payment->bank_detail }}</div>
                </div>
            @endif
        </div>
    </div>
</x-layout>
