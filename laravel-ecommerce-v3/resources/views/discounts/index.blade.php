<x-layout title="Discount List">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">List of Discounts ({{count( $discounts) }})</h2>
            <a href="{{ route('discounts.create') }}" class="btn btn-primary">Add Discount</a>
        </div>

        <div class="card shadow rounded-4 border-0 scroll-container p-4">
            <div class="list-group list-group-flush     ">
                @foreach($discounts as $discount)
                    <div class="list-group-item p-3 position-relative border-0 shadow-sm rounded-3 mb-3 bg-white">
                        <h5 class="fw-bold mb-2">
                            <a href="{{ route('discounts.show', $discount['id']) }}" class="text-decoration-none text-primary">
                                {{ $discount['discount_name'] }}
                            </a>
                        </h5>
                        <div><strong>ID:</strong> {{ $discount['id'] }}</div>
                        <div><strong>Description:</strong> {{ $discount['discount_description'] }}</div>
                        <div><strong>Percent:</strong> {{ $discount['discount_percent'] }}%</div>
                        <div><strong>Status:</strong>
                            @if($discount['active'])
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                    </div>
                @endforeach

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
