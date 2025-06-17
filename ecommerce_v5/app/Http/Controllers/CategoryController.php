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

        return redirect()->route('categories.index');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.show', compact('category'));
    }

    public function edit($id)
    {
      $category = Category::findOrFail($id);

      return view('categories.edit', compact('category'));
    }

    public function update(StoreCategoryRequest $request, $id)
    {
        $category=Category::findOrFail($id);

        $category->update($request->validated());

        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->route('categories.index');
    }
}
