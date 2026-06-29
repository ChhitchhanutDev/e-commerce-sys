<?php

namespace App\Http\Controllers\Api;

use App\Events\NewOrder;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    public function show(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $order->load('items.product'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $products = Product::whereIn('id', collect($validated['items'])->pluck('product_id'))
            ->get()
            ->keyBy('id');

        foreach ($validated['items'] as $item) {
            $product = $products->get($item['product_id']);

            if (! $product || ! $product->status) {
                $productName = $product?->name ?? $item['product_id'];

                return response()->json([
                    'success' => false,
                    'message' => "Product \"{$productName}\" is unavailable.",
                ], 400);
            }

            if ($product->stock < $item['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "Insufficient stock for \"{$product->name}\". Only {$product->stock} left.",
                ], 400);
            }
        }

        $order = DB::transaction(function () use ($validated, $products) {
            $totalAmount = collect($validated['items'])->sum(function ($item) use ($products) {
                return $products[$item['product_id']]->price * $item['quantity'];
            });

            $order = Order::create([
                'user_id' => request()->user()->id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
            ]);

            foreach ($validated['items'] as $item) {
                $product = $products[$item['product_id']];
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            return $order;
        });

        broadcast(new NewOrder($order->load('user')));

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully.',
            'data' => $order->load('items.product'),
        ], 201);
    }

    public function purchased(Request $request)
    {
        $items = OrderItem::whereHas('order', function ($q) use ($request) {
            $q->where('user_id', $request->user()->id);
        })
        ->whereHas('product', function ($q) {
            $q->where('status', true);
        })
        ->with('product.category')
        ->get()
        ->groupBy('product_id')
        ->map(function ($group) {
            $first = $group->first();

            return [
                'product' => $first->product,
                'total_quantity' => $group->sum('quantity'),
                'last_purchased_at' => $group->max('created_at'),
            ];
        })
        ->values();

        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }
}
