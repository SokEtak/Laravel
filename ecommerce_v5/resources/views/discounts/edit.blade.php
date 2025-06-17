<x-layout title="Edit Discount">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Edit Discount: {{ $discount['discount_name'] }}</h2>
            <a href="{{ route('discounts.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>

        <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white">
            <form action="{{ route('discounts.update', $discount['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="discount_name" class="form-label fw-semibold">Discount Name</label>
                        <input type="text" name="discount_name"
                               class="form-control form-control-lg rounded-3 bg-dark text-white border-secondary"
                               value="{{ old('discount_name', $discount['discount_name']) }}" required>
                        @error('discount_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="discount_percent" class="form-label fw-semibold">Discount Percent (%)</label>
                        <input type="number" step="0.01" name="discount_percent"
                               class="form-control form-control-lg rounded-3 bg-dark text-white border-secondary"
                               value="{{ old('discount_percent', $discount['discount_percent']) }}" required>
                        @error('discount_percent') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12">
                        <label for="discount_description" class="form-label fw-semibold">Description</label>
                        <textarea name="discount_description"
                                  class="form-control form-control-lg rounded-3 bg-dark text-white border-secondary"
                                  rows="4">{{ old('discount_description', $discount['discount_description']) }}</textarea>
                        @error('discount_description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="active" class="form-label fw-semibold">Active</label>
                        <select name="active"
                                class="form-select form-select-lg rounded-3 bg-dark text-white border-secondary" required>
                            <option value="1" {{ old('active', $discount['active']) == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('active', $discount['active']) == '0' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('active') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-light btn-lg px-4 rounded-3">Update Discount</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
