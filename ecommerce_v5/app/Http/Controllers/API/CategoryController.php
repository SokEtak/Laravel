<?php

namespace App\Http\Controllers\API;
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\categories\StoreCategoryRequest;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return response()->json([
            'message' => 'Category created successfully',
            'data' => new CategoryResource($category)
        ], 201);
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }
    }

    public function update(StoreCategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update($request->validated());
            return response()->json([
                'message' => 'Category updated successfully',
                'data' => new CategoryResource($category)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json([
                'message' => 'Category deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }
    }
}
