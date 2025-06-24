<x-layout title="Inventory List">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Inventory List({{ $inventories->count() }})</h2>
        </div>

{{--        @include('components.alerts.success',['bgClass' => 'text-bg-success', 'icon' => 'bi bi-archive'])--}}

        @if ($inventories->isEmpty())
            <div class="alert alert-info" role="alert">
                No inventory records found.
            </div>
        @else
            <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Created</th>
                            <th scope="col">Updated</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($inventories as $inventory)
                            <tr>
                                <td>{{ $inventory->id }}</td>
                                <td>
                                    @if($inventory->product)
                                        <a href="{{ route('products.show', $inventory->product->id) }}" class="text-info text-decoration-none">
                                            {{ $inventory->product->product_name }}
                                        </a>
                                    @else
                                        N/A (No Product Linked)
                                    @endif
                                </td>
                                <td>
                                    @if ($inventory->quantity < 10)
                                        <span class="text-danger">
                                            {{ $inventory->quantity }} <small>(Almost out)</small>
                                        </span>
                                    @else
                                        <span class="text-success">
                                            {{ $inventory->quantity }}
                                        </span>
                                    @endif
                                </td>

                                <td>{{ \Carbon\Carbon::parse($inventory->created_at)->timezone('Asia/Phnom_Penh')->diffForHumans() }}</td>
                                <td>{{ \Carbon\Carbon::parse($inventory->updated_at)->timezone('Asia/Phnom_Penh')->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('inventories.show', $inventory->id) }}" class="btn btn-sm btn-info me-1">View</a>
                                    <a href="{{ route('inventories.edit', $inventory->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
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
