<?php

namespace App\Http\Controllers\Api;

use App\Events\NewOrder;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'phone_number' => 'required|string|max:20',
        ]);

        $user = $request->user();

        $cart = Cart::with('items.product')
            ->where('user_id', $user->id)
            ->first();

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.',
            ], 400);
        }

        foreach ($cart->items as $cartItem) {
            if (! $cartItem->product || ! $cartItem->product->status) {
                $productName = $cartItem->product?->name ?? 'A product';

                return response()->json([
                    'success' => false,
                    'message' => "\"{$productName}\" is no longer available. Please remove it from your cart.",
                ], 400);
            }

            if ($cartItem->product->stock < $cartItem->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Insufficient stock for \"{$cartItem->product->name}\". Only {$cartItem->product->stock} left.",
                ], 400);
            }
        }

        $order = DB::transaction(function () use ($cart, $user, $validated) {
            $totalAmount = $cart->items->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
                'phone_number' => $validated['phone_number'],
            ]);

            foreach ($cart->items as $cartItem) {
                $order->items()->create([
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'subtotal' => $cartItem->price * $cartItem->quantity,
                ]);

                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            $cart->items()->delete();

            return $order;
        });

        broadcast(new NewOrder($order->load('user')));

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully.',
            'data' => $order->load('items.product'),
        ], 201);
    }
}
