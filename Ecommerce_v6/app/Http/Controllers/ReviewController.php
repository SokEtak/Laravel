<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ReviewController extends Controller
{
    public function index(): Response
    {
        $reviews = Review::with('product', 'user')->get();
        return Inertia::render('Reviews/Index', [
            'reviews' => $reviews,
        ]);
    }

    public function create(): Response
    {
        $products = Product::all(['id', 'name']);
        $users = User::all(['id', 'username']);
        return Inertia::render('Reviews/Create', [
            'products' => $products,
            'users' => $users,
        ]);
    }

    public function store(StoreReviewRequest $request): RedirectResponse
    {
        Review::create($request->validated());
        return redirect()->route('reviews.index')->with('success', 'Review created successfully!');
    }

    public function show(Review $review): Response
    {
        $review->load('product', 'user');
        return Inertia::render('Reviews/Show', [
            'review' => $review,
        ]);
    }

    public function edit(Review $review): Response
    {
        $products = Product::all(['id', 'name']);
        $users = User::all(['id', 'username']);
        return Inertia::render('Reviews/Edit', [
            'review' => $review,
            'products' => $products,
            'users' => $users,
        ]);
    }

    public function update(UpdateReviewRequest $request, Review $review): RedirectResponse
    {
        $review->update($request->validated());
        return redirect()->route('reviews.index')->with('success', 'Review updated successfully!');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();
        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully!');
    }
}
