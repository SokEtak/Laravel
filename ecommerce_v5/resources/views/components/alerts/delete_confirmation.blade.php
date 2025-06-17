{{-- resources/views/components/modals/delete-confirmation.blade.php --}}
@props([
    'id',          // Unique ID for the modal (e.g., 'deleteProductModal', 'deleteUserModal')
    'action',      // The route for the form submission (e.g., route('products.destroy', $item->id))
    'title' => 'Confirm Deletion', // Modal title
    'body' => 'Are you sure you want to delete this item?', // Modal body message
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ $action }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="{{ $id }}Label">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-black">
                    {{ $body }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>