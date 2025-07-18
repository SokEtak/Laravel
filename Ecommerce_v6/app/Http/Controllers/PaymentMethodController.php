<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethod\StorePaymentMethodRequest;
use App\Http\Requests\PaymentMethod\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PaymentMethodController extends Controller
{
    public function index(): Response
    {
        $paymentMethods = PaymentMethod::with('user')->get();
        return Inertia::render('PaymentMethods/Index', [
            'paymentMethods' => $paymentMethods,
        ]);
    }

    public function create(): Response
    {
        $users = User::all(['id', 'username']);
        return Inertia::render('PaymentMethods/Create', [
            'users' => $users,
        ]);
    }

    public function store(StorePaymentMethodRequest $request): RedirectResponse
    {
        PaymentMethod::create($request->validated());
        return redirect()->route('payment-methods.index')->with('success', 'Payment Method created successfully!');
    }

    public function show(PaymentMethod $paymentMethod): Response
    {
        $paymentMethod->load('user');
        return Inertia::render('PaymentMethods/Show', [
            'paymentMethod' => $paymentMethod,
        ]);
    }

    public function edit(PaymentMethod $paymentMethod): Response
    {
        $users = User::all(['id', 'username']);
        return Inertia::render('PaymentMethods/Edit', [
            'paymentMethod' => $paymentMethod,
            'users' => $users,
        ]);
    }

    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod): RedirectResponse
    {
        $paymentMethod->update($request->validated());
        return redirect()->route('payment-methods.index')->with('success', 'Payment Method updated successfully!');
    }

    public function destroy(PaymentMethod $paymentMethod): RedirectResponse
    {
        $paymentMethod->delete();
        return redirect()->route('payment-methods.index')->with('success', 'Payment Method deleted successfully!');
    }
}
