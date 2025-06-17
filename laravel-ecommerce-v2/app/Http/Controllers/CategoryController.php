<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    protected $apiBase = 'http://127.0.0.1:8000/api/v1/categories';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get($this->apiBase);

        if ($response->successful()) {
            $categories = $response->json('data');
            return view('categories.index', compact('categories'));
        }

        return response()->view('errors.500', ['message' => 'Error fetching category data.'], 500);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'category_description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $response = Http::post($this->apiBase, $validator->validated());

        if ($response->successful()) {
            return redirect()->route('categories.index')->with('success', 'Category created successfully.');
        }

        return back()->with('error', 'Failed to create category.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $response = Http::get("{$this->apiBase}/{$id}");

        if ($response->successful()) {
            $category = $response->json('data');
            return view('categories.show', compact('category'));
        }

        return response()->view('errors.404', ['message' => 'Category not found.'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $response = Http::get("{$this->apiBase}/{$id}");

        if ($response->successful()) {
            $category = $response->json('data');
            return view('categories.edit', compact('category'));
        }

        return response()->view('errors.404', ['message' => 'Category not found.'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'category_description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $response = Http::put("{$this->apiBase}/{$id}", $validator->validated());

        if ($response->successful()) {
            return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
        }

        return back()->with('error', 'Failed to update category.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = Http::delete("{$this->apiBase}/{$id}");

        if ($response->successful()) {
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
        }

        return back()->with('error', 'Failed to delete category.');
    }
}
