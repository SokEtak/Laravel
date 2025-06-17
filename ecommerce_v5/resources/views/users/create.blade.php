<x-layout title="Create New User">
    <div class="container mt-5">
        <div class="card shadow-sm rounded-4 p-4 bg-dark text-white">
            <h2 class="mb-4">Create New User</h2>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <input type="text" name="name" id="name" class="form-control bg-secondary text-white"
                           value="{{ old('name') }}" required>
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="email" class="form-control bg-secondary text-white"
                           value="{{ old('email') }}" required>
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" id="password" class="form-control bg-secondary text-white" required>
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">Create User</button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <style>
            body {
                background-color: #1c1c1c;
            }
            .form-control {
                border: 1px solid #6c757d;
            }
        </style>
    @endpush
</x-layout>
