<?php

namespace App\Http\Controllers;

use App\Http\Requests\categories\StoreCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return view('categories.show', compact('category'));
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }
    }

    public function edit($id)
    {

        try {
            $category = Category::findOrFail($id);
            return view('categories.edit', compact('category'));
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }
    }

    public function update(StoreCategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update($request->validated());
            return redirect()->route('categories.index')->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }
    }
}
