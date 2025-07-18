<?php

namespace App\Http\Controllers;

use App\Models\ProductLike;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

// To get the authenticated user

class ProductLikeController extends Controller
{
    /**
     * Display a listing of the resource (e.g., liked products for the current user).
     */
    public function index(): Response
    {
        // Only show likes for the authenticated user
        $productLikes = ProductLike::where('user_id', Auth::id())
            ->with('product') // Eager load the product details
            ->get();
        return Inertia::render('ProductLikes/Index', [
            'productLikes' => $productLikes,
        ]);
    }

    /**
     * Show the form for creating a new resource. (Usually not needed for likes; handled by action)
     */
    // public function create(): Response { /* ... */ }

    /**
     * Store a newly created resource in storage. (Usually handled by a specific 'like' action)
     */
    // public function store(StoreProductLikeRequest $request): RedirectResponse { /* ... */ }

    /**
     * Display the specified resource.
     */
    public function show(ProductLike $productLike): Response
    {
        // Ensure the user can only view their own like
        if ($productLike->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        $productLike->load('product', 'user');
        return Inertia::render('ProductLikes/Show', [
            'productLike' => $productLike,
        ]);
    }

    /**
     * Show the form for editing the specified resource. (Usually not applicable for likes)
     */
    // public function edit(ProductLike $productLike): Response { /* ... */ }

    /**
     * Update the specified resource in storage. (Likes are generally binary, not updated)
     */
    // public function update(UpdateProductLikeRequest $request, ProductLike $productLike): RedirectResponse { /* ... */ }

    /**
     * Remove the specified resource from storage (e.g., "Unlike" action).
     */
    public function destroy(ProductLike $productLike): RedirectResponse
    {
        // Ensure the user can only delete their own like
        if ($productLike->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        $productLike->delete();
        return redirect()->route('product-likes.index')->with('success', 'Product unliked successfully!');
    }
}
