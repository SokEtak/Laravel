@if(session()->has('success'))
    <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080;">
        <div class="toast show text-bg-success border-0 shadow-lg px-4 py-3 w-auto"
             role="alert"
             aria-live="assertive"
             aria-atomic="true"
             id="success-toast"
             data-bs-delay="2000"
             data-bs-autohide="true"
             style="max-width: 90vw; font-size: 1rem; word-break: break-word; margin-top: 13.8%">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toastEl = document.getElementById('success-toast');
                if (toastEl) {
                    new bootstrap.Toast(toastEl).show();
                }
            });
        </script>
    @endpush
@endif
