<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartSession\StoreCartSessionRequest;
use App\Http\Requests\CartSession\UpdateCartSessionRequest;
use App\Models\CartSession;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

// For item management methods

class CartSessionController extends Controller
{
    public function index(): Response
    {
        $cartSessions = CartSession::with('user')->get();
        return Inertia::render('CartSessions/Index', [
            'cartSessions' => $cartSessions,
        ]);
    }

    public function create(): Response
    {
        $users = User::all(['id', 'username']);
        return Inertia::render('CartSessions/Create', [
            'users' => $users,
        ]);
    }

    public function store(StoreCartSessionRequest $request): RedirectResponse
    {
        $cartSession = CartSession::create($request->validated());
        return redirect()->route('cart-sessions.show', $cartSession)->with('success', 'Cart Session created successfully!');
    }

    public function show(CartSession $cartSession): Response
    {
        $cartSession->load('user', 'cartItems.product');
        $products = Product::all(['id', 'name']); // For adding new items
        return Inertia::render('CartSessions/Show', [
            'cartSession' => $cartSession,
            'products' => $products,
        ]);
    }

    public function edit(CartSession $cartSession): Response
    {
        $users = User::all(['id', 'username']);
        return Inertia::render('CartSessions/Edit', [
            'cartSession' => $cartSession,
            'users' => $users,
        ]);
    }

    public function update(UpdateCartSessionRequest $request, CartSession $cartSession): RedirectResponse
    {
        $cartSession->update($request->validated());
        return redirect()->route('cart-sessions.show', $cartSession)->with('success', 'Cart Session updated successfully!');
    }

    public function destroy(CartSession $cartSession): RedirectResponse
    {
        $cartSession->delete();
        return redirect()->route('cart-sessions.index')->with('success', 'Cart Session deleted successfully!');
    }

    // --- Methods to manage cart items within a session ---
    /**
     * Add a product to a cart session (or update quantity if exists).
     */
    public function addItem(Request $request, CartSession $cartSession): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $item = $cartSession->cartItems()->where('product_id', $request->product_id)->first();

        if ($item) {
            $item->quantity += $request->quantity;
            $item->save();
            $message = 'Product quantity updated in cart!';
        } else {
            $cartSession->cartItems()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
            $message = 'Product added to cart!';
        }

        return redirect()->route('cart-sessions.show', $cartSession)->with('success', $message);
    }

    /**
     * Update quantity of a specific cart item.
     */
    public function updateItem(Request $request, CartSession $cartSession, int $productId): RedirectResponse
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $item = $cartSession->cartItems()->where('product_id', $productId)->first();

        if (!$item) {
            return redirect()->back()->with('error', 'Cart item not found.');
        }

        if ($request->quantity == 0) {
            $item->delete();
            return redirect()->route('cart-sessions.show', $cartSession)->with('success', 'Product removed from cart!');
        } else {
            $item->quantity = $request->quantity;
            $item->save();
            return redirect()->route('cart-sessions.show', $cartSession)->with('success', 'Cart item quantity updated!');
        }
    }

    /**
     * Remove a specific cart item.
     */
    public function removeItem(CartSession $cartSession, int $productId): RedirectResponse
    {
        $item = $cartSession->cartItems()->where('product_id', $productId)->first();

        if ($item) {
            $item->delete();
            return redirect()->route('cart-sessions.show', $cartSession)->with('success', 'Product removed from cart!');
        }

        return redirect()->back()->with('error', 'Cart item not found.');
    }
}
