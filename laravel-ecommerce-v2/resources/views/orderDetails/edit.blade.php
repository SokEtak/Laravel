<x-layout title="Edit Inventory">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Edit Inventory #{{ $inventory['id'] }}</h2>
            <a href="{{ route('inventories.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 bg-white">
            <form action="{{ route('inventories.update', $inventory['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="quantity" class="form-label fw-semibold">Quantity</label>
                        <input
                            type="number"
                            name="quantity"
                            id="quantity"
                            class="form-control form-control-lg rounded-3"
                            value="{{ old('quantity', $inventory['quantity']) }}"
                            required
                            min="1"
                            max="99"
                        >
                        @error('quantity')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- You can optionally include related product dropdown here if relevant --}}

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-dark btn-lg px-4 rounded-3">Update Inventory</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
