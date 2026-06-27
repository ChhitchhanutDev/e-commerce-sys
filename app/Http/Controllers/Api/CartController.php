<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::with('items.product.category')
            ->where('user_id', $request->user()->id)
            ->first();

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'items' => [],
                    'total' => 0,
                ],
            ]);
        }

        $total = $cart->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $cart->items,
                'total' => round($total, 2),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if (! $product->status) {
            return response()->json([
                'success' => false,
                'message' => 'This product is currently unavailable.',
            ], 400);
        }

        $cart = Cart::firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        $existingItem = $cart->items()->where('product_id', $validated['product_id'])->first();

        $totalQuantity = ($existingItem ? $existingItem->quantity : 0) + $validated['quantity'];

        if ($product->stock < $totalQuantity) {
            return response()->json([
                'success' => false,
                'message' => "Insufficient stock. Only {$product->stock} left.",
            ], 400);
        }

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $totalQuantity,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'price' => $product->price,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart.',
            'data' => $this->cartData($cart),
        ], 201);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update(['quantity' => $validated['quantity']]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated.',
            'data' => $this->cartData($cartItem->cart),
        ]);
    }

    public function destroy(Request $request, CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'data' => $this->cartData($cartItem->cart),
        ]);
    }

    private function cartData(Cart $cart): array
    {
        $cart->load('items.product.category');

        $total = $cart->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return [
            'items' => $cart->items,
            'total' => round($total, 2),
        ];
    }
}
