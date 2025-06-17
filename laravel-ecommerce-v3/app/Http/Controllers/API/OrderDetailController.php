<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class OrderDetailController extends Controller
{
    protected $apiBaseUrl = 'http://127.0.0.1:8000/api/v1/order-details';

    public function index()
    {
        $response = Http::get($this->apiBaseUrl);

        if ($response->successful()) {
            $orderDetails = $response->json('data');
            return view('order_details.index', compact('orderDetails'));
        }

        return response()->view('errors.500', ['message' => 'Error fetching order details.'], 500);
    }

    public function create()
    {
        return view('order_details.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $response = Http::post($this->apiBaseUrl, $validator->validated());

        if ($response->successful()) {
            return redirect()->route('order-details.index')->with('success', 'Order detail created successfully.');
        }

        return back()->with('error', 'Failed to create order detail.');
    }

    public function show($id)
    {
        $response = Http::get("{$this->apiBaseUrl}/{$id}");

        if ($response->successful()) {
            $orderDetail = $response->json('data');
            return view('order_details.show', compact('orderDetail'));
        }

        return abort(404, 'Order detail not found.');
    }

    public function edit($id)
    {
        $response = Http::get("{$this->apiBaseUrl}/{$id}");

        if ($response->successful()) {
            $orderDetail = $response->json('data');
            return view('order_details.edit', compact('orderDetail'));
        }

        return abort(404, 'Order detail not found.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $response = Http::put("{$this->apiBaseUrl}/{$id}", $validator->validated());

        if ($response->successful()) {
            return redirect()->route('order-details.index')->with('success', 'Order detail updated successfully.');
        }

        return back()->with('error', 'Failed to update order detail.');
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiBaseUrl}/{$id}");

        if ($response->successful()) {
            return redirect()->route('order-details.index')->with('success', 'Order detail deleted successfully.');
        }

        return back()->with('error', 'Failed to delete order detail.');
    }
}
