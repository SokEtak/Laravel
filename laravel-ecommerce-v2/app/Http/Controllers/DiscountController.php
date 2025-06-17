<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    protected $apiBase = 'http://127.0.0.1:8000/api/v1/discounts';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get($this->apiBase);

        if ($response->successful()) {
            $discounts = $response->json('data');
            return view('discounts.index', compact('discounts'));
        }

        return response()->view('errors.500', ['message' => 'Error fetching discount data.'], 500);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount_name' => 'required|string|max:255',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'discount_description' => 'required|string',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $response = Http::post($this->apiBase, $validator->validated());

        if ($response->successful()) {
            return redirect()->route('discounts.index')->with('success', 'Discount created successfully.');
        }

        return back()->with('error', 'Failed to create discount.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $response = Http::get("{$this->apiBase}/{$id}");

        if ($response->successful()) {
            $discount = $response->json('data');
            return view('discounts.show', compact('discount'));
        }

        return redirect()->route('discounts.index')->with('error', 'Discount not found.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $response = Http::get("{$this->apiBase}/{$id}");

        if ($response->successful()) {
            $discount = $response->json('data');
            return view('discounts.edit', compact('discount'));
        }

        return redirect()->route('discounts.index')->with('error', 'Discount not found.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'discount_name' => 'required|string|max:255',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'discount_description' => 'required|string',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $response = Http::put("{$this->apiBase}/{$id}", $validator->validated());

        if ($response->successful()) {
            return redirect()->route('discounts.index')->with('success', 'Discount updated successfully.');
        }

        return back()->with('error', 'Failed to update discount.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = Http::delete("{$this->apiBase}/{$id}");

        if ($response->successful()) {
            return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully.');
        }

        return back()->with('error', 'Failed to delete discount.');
    }
}
