<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod as PaymentGatewayMethod;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    public function index(): Response
    {
        $payments = Payment::with('order', 'paymentMethod')->get();
        return Inertia::render('Payments/Index', [
            'payments' => $payments,
        ]);
    }

    public function create(): Response
    {
        $orders = Order::all(['id']); // Only need ID for selection
        $paymentMethods = PaymentGatewayMethod::all(['id', 'type', 'provider']);
        return Inertia::render('Payments/Create', [
            'orders' => $orders,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    public function store(StorePaymentRequest $request): RedirectResponse
    {
        Payment::create($request->validated());
        return redirect()->route('payments.index')->with('success', 'Payment created successfully!');
    }

    public function show(Payment $payment): Response
    {
        $payment->load('order', 'paymentMethod');
        return Inertia::render('Payments/Show', [
            'payment' => $payment,
        ]);
    }

    public function edit(Payment $payment): Response
    {
        $orders = Order::all(['id']);
        $paymentMethods = PaymentGatewayMethod::all(['id', 'type', 'provider']);
        return Inertia::render('Payments/Edit', [
            'payment' => $payment,
            'orders' => $orders,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    public function update(UpdatePaymentRequest $request, Payment $payment): RedirectResponse
    {
        $payment->update($request->validated());
        return redirect()->route('payments.index')->with('success', 'Payment updated successfully!');
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully!');
    }
}
