<x-layout title="User Details">
    <div class="container my-5">
        {{-- User Info Header --}}
        @if(isset($user))
            <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white mb-4">
                <h2 class="mb-3">User Information</h2>
                <div class="row">
                    <div class="col-md-6 mb-2"><strong>ID:</strong> <span class="text-info">{{ $user->id }}</span></div>
                    <div class="col-md-6 mb-2"><strong>Name:</strong> <span class="text-light">{{ $user->name }}</span>
                    </div>
                    <div class="col-md-6 mb-2"><strong>Email:</strong> <span
                            class="text-light">{{ $user->email }}</span></div>
                    <div class="col-md-6 mb-2"><strong>Role:</strong> <span
                            class="text-light">{{ ucfirst($user->role ?? 'user') }}</span></div>
                    <div class="col-md-6 mb-2"><strong>Registered:</strong> <span
                            class="text-light">{{ \Carbon\Carbon::parse($user->created_at)->timezone('Asia/Phnom_Penh')->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        @endif

        {{-- Order History Table --}}
        <div class="card shadow rounded-4 border-0 p-4 bg-dark text-white">
            <h3 class="mb-3">Order History ({{ count($orders) }})</h3>

            @if(count($orders))
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">Total</th>
                            <th scope="col">Order Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-info fw-semibold">
                                    <a href="javascript:void(0);"
                                       class="text-decoration-none text-info order-click-trigger"
                                       data-bs-toggle="modal"
                                       data-bs-target="#orderModal{{ $order['id'] }}">
                                        #{{ $order['id'] }}
                                    </a>
                                </td>
                                <td>${{ number_format($order['total'], 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($order['created_at'])->timezone('Asia/Phnom_Penh')->format('Y-m-d H:i:s') }}</td>
                            </tr>

                            {{-- Modal --}}
                            <div class="modal fade" id="orderModal{{ $order['id'] }}" tabindex="-1"
                                 aria-labelledby="orderModalLabel{{ $order['id'] }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content bg-dark text-white border border-secondary">
                                        <div class="modal-header border-secondary cursor-move">
                                            <h5 class="modal-title text-info fw-bold"
                                                id="orderModalLabel{{ $order['id'] }}">
                                                Order Details #{{ $order['id'] }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <iframe src="{{ route('orderDetails.show', $order['id']) }}"
                                                    frameborder="0"
                                                    style="width: 100%; height: 90vh;"
                                                    class="w-100 border-0 draggable-iframe">
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No orders found.</p>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            .modal-dialog {
                position: absolute !important;
            }

            .order-click-trigger:hover {
                color: #0dcaf0;
                text-decoration: underline;
            }

            .modal-content {
                box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
                height: 100%;
            }

            .modal-title {
                font-size: 1.2rem;
                text-shadow: 0 0 2px #0dcaf0;
            }

            iframe {
                border-radius: 0 0 10px 10px;
            }

            /*.ui-resizable-handle {*/
            /*    background: #0dcaf0;*/
            /*    border: 1px solid #fff;*/
            /*    height: 10px;*/
            /*    width: 10px;*/
            /*}*/

            /*.ui-resizable-n {*/
            /*    top: -5px;*/
            /*    left: 50%;*/
            /*    margin-left: -5px;*/
            /*    cursor: n-resize;*/
            /*}*/

            /*.ui-resizable-s {*/
            /*    bottom: -5px;*/
            /*    left: 50%;*/
            /*    margin-left: -5px;*/
            /*    cursor: s-resize;*/
            /*}*/

            /*.ui-resizable-e {*/
            /*    right: -5px;*/
            /*    top: 50%;*/
            /*    margin-top: -5px;*/
            /*    cursor: e-resize;*/
            /*}*/

            /*.ui-resizable-w {*/
            /*    left: -5px;*/
            /*    top: 50%;*/
            /*    margin-top: -5px;*/
            /*    cursor: w-resize;*/
            /*}*/

            /*.ui-resizable-se {*/
            /*    right: -5px;*/
            /*    bottom: -5px;*/
            /*    cursor: se-resize;*/
            /*}*/

            /*.ui-resizable-sw {*/
            /*    left: -5px;*/
            /*    bottom: -5px;*/
            /*    cursor: sw-resize;*/
            /*}*/

            /*.ui-resizable-nw {*/
            /*    left: -5px;*/
            /*    top: -5px;*/
            /*    cursor: nw-resize;*/
            /*}*/

            /*.ui-resizable-ne {*/
            /*    right: -5px;*/
            /*    top: -5px;*/
            /*    cursor: ne-resize;*/
            /*}*/
        </style>
    @endpush

    @push('scripts')
            <script>
                $(document).ready(function () {
                    $('.order-click-trigger').on('click', function () {
                        const targetId = $(this).data('bs-target');
                        const $modal = $(targetId);

                        $modal.on('shown.bs.modal', function () {
                            const $dialog = $modal.find('.modal-dialog');

                            if (!$dialog.hasClass('ui-draggable')) {
                                $dialog.draggable({
                                    handle: ".modal-header",
                                    containment: "window"
                                });
                            }
                        });
                    });
                });
            </script>
    @endpush
</x-layout>
