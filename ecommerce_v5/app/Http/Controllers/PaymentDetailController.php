<?php

namespace App\Http\Controllers;

use App\Http\Requests\orders\orders\payments\StorePaymentDetailRequest;
use App\Models\OrderDetail;
use App\Models\PaymentDetail;


class PaymentDetailController extends Controller
{
    public function index()
    {
        $payments = PaymentDetail::all();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $orders = OrderDetail::select('id', 'total')->get();
        return view('payments.create', compact('orders'));
    }

    public function store(StorePaymentDetailRequest $request)
    {
        PaymentDetail::create($request->validated());

        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
    }

    public function show($id)
    {
        $payment = PaymentDetail::with('order')->findOrFail($id); // include related order
        return view('payments.show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = PaymentDetail::findOrFail($id);
        $orders = OrderDetail::select('id', 'total')->get();

        return view('payments.edit', compact('payment', 'orders'));
    }

    public function update(StorePaymentDetailRequest $request, $id)
    {
        $payment = PaymentDetail::findOrFail($id);

        $payment->update($request->validated());

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy($id)
    {
        $payment = PaymentDetail::findOrFail($id);
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}
