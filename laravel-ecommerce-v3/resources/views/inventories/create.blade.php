<x-layout title="Add New Inventory">
    <div class="container mt-5">
        <div class="card border-0 shadow-sm rounded-4 px-4 py-3" style="background-color: #4ED7F1;">
            <div class="card-header border-0 bg-white px-0 pb-0">
                <h3 class="fw-semibold">Create New Inventory</h3>
                <p class="text-muted">Fill out the form below to add a new inventory record.</p>
            </div>

            <div class="card-body px-0">
                <form action="{{ route('inventories.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label fw-semibold">Quantity</label>
                            <input type="number" name="quantity" class="form-control form-control-lg rounded-3"
                                   value="{{ old('quantity') }}" required min="1" max="99">
                            @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Optional: Add product dropdown if needed in the future --}}

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-dark btn-lg px-4 rounded-3">Create Inventory</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
