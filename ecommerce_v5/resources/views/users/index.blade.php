<x-layout title="User List">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            @if(isset($users) && count($users))
                <h2 class="mb-0">User List ({{ count($users) }})</h2>
            @else
                <h2 class="mb-0">No users available.</h2>
            @endif

            <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
        </div>

        {{-- Styled Card Container --}}
        <div class="card shadow rounded-4 border-0 scroll-container p-4 bg-dark text-white">
            <div class="list-group list-group-flush">
                @foreach($users as $user)
                    <div class="list-group-item p-3 position-relative user-item border-0 shadow-sm rounded-3 mb-3" style="background-color: #343a40; color: #fff;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold fs-5">
                                {{ $user['id'] }} - {{ $user['name'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .user-item:hover {
                background-color: #3c434c;
            }

            .scroll-container {
                max-height: 75vh;
                overflow-y: auto;
                background-color: transparent;
            }

            .user-item {
                position: relative;
                cursor: pointer;
                transition: background 0.3s ease;
            }
        </style>
    @endpush
</x-layout>
