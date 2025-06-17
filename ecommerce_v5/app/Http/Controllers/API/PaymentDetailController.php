<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\orders\orders\payments\StorePaymentDetailRequest;
use App\Http\Resources\PaymentDetailResource;
use App\Models\PaymentDetail;

class PaymentDetailController extends Controller
{
    public function index()
    {
        return PaymentDetailResource::collection(PaymentDetail::all());
    }

    public function store(StorePaymentDetailRequest $request)
    {
        $payment = PaymentDetail::create($request->validated());
        return new PaymentDetailResource($payment);
    }

    public function show($id)
    {
        $payment = PaymentDetail::findOrFail($id);

        return new PaymentDetailResource($payment);
    }

    public function update(StorePaymentDetailRequest $request, $id)
    {
        $payment = PaymentDetail::findOrFail($id);
        $payment->update($request->validated());

        return new PaymentDetailResource($payment);
    }

    public function destroy($id)
    {
        $payment = PaymentDetail::findOrFail($id);
        $payment->delete();

        return response()->json(null, 204);
    }
}
