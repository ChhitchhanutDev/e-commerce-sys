<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlist = $request->user()->wishlists()->with('category')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $wishlist,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = $request->user();

        if ($user->wishlists()->where('product_id', $validated['product_id'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist.',
            ], 409);
        }

        $user->wishlists()->attach($validated['product_id']);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist.',
            'data' => $user->wishlists()->with('category')->get(),
        ], 201);
    }

    public function destroy(Request $request, Product $product)
    {
        $request->user()->wishlists()->detach($product->id);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist.',
        ]);
    }
}
