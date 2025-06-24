<x-layout title="Discount List">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Discount List ({{ $discounts->count() }})</h2>
            <a href="{{ route('discounts.create') }}" class="btn btn-primary">Add Discount</a>
        </div>

        @if (session('success'))
            @include('components.alerts.success', ['bgClass' => 'text-bg-success', 'icon' => 'bi bi-percent'])
        @endif

        @if ($discounts->isEmpty())
            <div class="alert alert-info" role="alert">
                No discount records found.
            </div>
        @else
            <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Percent</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created</th>
                            <th scope="col">Updated</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($discounts as $discount)
                            <tr>
                                <td>{{ $discount->id }}</td>
                                <td>
                                    <a href="{{ route('discounts.show', $discount->id) }}"
                                       class="text-info text-decoration-none">
                                        {{ $discount->discount_name }}
                                    </a>
                                </td>
                                <td class="text-info">{{ $discount->discount_percent }}%</td>
                                <td>
                                    @if($discount->active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($discount->created_at)->timezone('Asia/Phnom_Penh')->diffForHumans() }}</td>
                                <td>{{ \Carbon\Carbon::parse($discount->updated_at)->timezone('Asia/Phnom_Penh')->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('discounts.show', $discount->id) }}"
                                       class="btn btn-sm btn-info me-1">View</a>
                                    <a href="{{ route('discounts.edit', $discount->id) }}"
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
</x-layout>
