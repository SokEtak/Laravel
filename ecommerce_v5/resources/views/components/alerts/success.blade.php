@props([
    'message' => session('success') ?? 'Operation completed successfully.',
    'bgClass' => 'text-bg-success',
    'icon' => 'bi-check-circle-fill'
])

@if(session()->has('success'))
    <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080;">
        <div class="toast show {{ $bgClass }} border-0 shadow-lg px-4 py-3 w-auto"
             role="alert"
             aria-live="assertive"
             aria-atomic="true"
             id="success-toast"
             data-bs-delay="2000"
             data-bs-autohide="true"
             style="max-width: 90vw; font-size: 1rem; word-break: break-word; margin-top: 13.8%">
            <div class="d-flex align-items-center gap-2">
                <i class="bi {{ $icon }} fs-5"></i>
                <div class="flex-grow-1">{{ $message }}</div>
                {{--x button--}}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .toast {
                transition: opacity 0.5s ease-in-out;
            }
        </style>
    @endpush()

    @once
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const toastEl = document.getElementById('success-toast');
                    if (toastEl) {
                        const toast = new bootstrap.Toast(toastEl);
                        toast.show();

                        toastEl.addEventListener('hidden.bs.toast', function () {
                            toastEl.parentElement.remove();
                        });
                    }
                });
            </script>
        @endpush
    @endonce
@endif
