<x-layout title="User List">
    <div class="container my-5">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            @if(isset($users) && count($users))
                <h2 class="mb-0">User List ({{ count($users) }})</h2>
            @else
                <h2 class="mb-0">No users available.</h2>
            @endif

            <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
        </div>

        {{-- User Table --}}
        @if(isset($users) && count($users))
            <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Created</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <a href="{{ route('users.show', $user->id) }}"
                                       class="text-info text-decoration-none">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role ?? 'user') }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->timezone('Asia/Phnom_Penh')->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info me-1">View</a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    @push('styles')
        <style>
            .table td, .table th {
                vertical-align: middle;
            }
        </style>
    @endpush
</x-layout>
