<x-layout title="Add New Discount">
    <div class="container mt-5">
        <div class="card border-0 shadow-sm rounded-4 px-4 py-3 bg-dark text-white">
            <div class="card-header border-0 bg-dark px-0 pb-0">
                <h3 class="fw-semibold">Create New Discount</h3>
                <p class="text-light">Fill out the form below to add a new discount.</p>
            </div>

            <div class="card-body px-0">
                <form action="{{ route('discounts.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="discount_name" class="form-label fw-semibold text-white">Discount Name</label>
                            <input type="text" name="discount_name"
                                   class="form-control form-control-lg rounded-3 bg-dark text-white border-secondary"
                                   value="{{ old('discount_name') }}" required>
                            @error('discount_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="discount_percent" class="form-label fw-semibold text-white">Discount Percent (%)</label>
                            <input type="number" step="0.01" name="discount_percent"
                                   class="form-control form-control-lg rounded-3 bg-dark text-white border-secondary"
                                   value="{{ old('discount_percent') }}" required>
                            @error('discount_percent') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12">
                            <label for="discount_description" class="form-label fw-semibold text-white">Description</label>
                            <textarea name="discount_description"
                                      class="form-control form-control-lg rounded-3 bg-dark text-white border-secondary"
                                      rows="4">{{ old('discount_description') }}</textarea>
                            @error('discount_description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="active" class="form-label fw-semibold text-white">Active</label>
                            <select name="active"
                                    class="form-select form-select-lg rounded-3 bg-dark text-white border-secondary"
                                    required>
                                <option value="1" {{ old('active') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('active') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-light btn-lg px-4 rounded-3">Create Discount</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
