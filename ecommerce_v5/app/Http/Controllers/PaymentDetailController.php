<?php

namespace App\Http\Controllers;

use App\Http\Requests\orders\orders\payments\StorePaymentDetailRequest;
use App\Models\OrderDetail;
use App\Models\PaymentDetail;
use Illuminate\Support\Facades\Log;
use Throwable;

class PaymentDetailController extends Controller
{
    public function index()
    {
        $payments = PaymentDetail::all();
        return view('payments.index', compact('payments'));
    }

    /*
    public function create()
    {
        try {
            $orders = OrderDetail::select('id', 'total')->get();
            return view('payments.create', compact('orders'));
        } catch (Throwable $e) {
            Log::error('Error loading payment creation form: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('payments.index')->with('error', 'Failed to load payment form.');
        }
    }

    public function store(StorePaymentDetailRequest $request)
    {
        try {
            PaymentDetail::create($request->validated());
            return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
        } catch (Throwable $e) {
            Log::error('Error storing payment: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Failed to create payment.');
        }
    }
    */

    public function show($id)
    {
        try {
            $payment = PaymentDetail::with('order')->findOrFail($id); // include related order
            return view('payments.show', compact('payment'));
        } catch (Throwable $e) {
            Log::error("Error showing payment ID $id: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('payments.index')->with('error', 'Payment not found or an error occurred.');
        }
    }

    /*
    public function edit($id)
    {
        try {
            $payment = PaymentDetail::findOrFail($id);
            $orders = OrderDetail::select('id', 'total')->get();
            return view('payments.edit', compact('payment', 'orders'));
        } catch (Throwable $e) {
            Log::error("Error editing payment ID $id: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('payments.index')->with('error', 'Failed to load payment edit form.');
        }
    }

    public function update(StorePaymentDetailRequest $request, $id)
    {
        try {
            $payment = PaymentDetail::findOrFail($id);
            $payment->update($request->validated());
            return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
        } catch (Throwable $e) {
            Log::error("Error updating payment ID $id: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Failed to update payment.');
        }
    }

    public function destroy($id)
    {
        try {
            $payment = PaymentDetail::findOrFail($id);
            $payment->delete();
            return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
        } catch (Throwable $e) {
            Log::error("Error deleting payment ID $id: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('payments.index')->with('error', 'Failed to delete payment.');
        }
    }
    */
}
