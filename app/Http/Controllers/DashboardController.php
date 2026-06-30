<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $data = Cache::remember('dashboard.stats', 300, function () {
            return [
                'totalOrders' => Order::count(),
                'totalRevenue' => Order::where('status', 'completed')->sum('total_amount'),
                'totalCustomers' => User::where('role', 'user')->count(),
                'totalProducts' => Product::count(),
                'pendingOrders' => Order::where('status', 'pending')->count(),

                'bestSelling' => OrderItem::selectRaw('product_id, SUM(quantity) as sold, SUM(subtotal) as revenue')
                    ->whereHas('order', function ($q) {
                        $q->where('status', 'completed');
                    })
                    ->with('product.category')
                    ->groupBy('product_id')
                    ->orderByDesc('sold')
                    ->limit(5)
                    ->get(),

                'lowStock' => Product::where('stock', '<=', 5)
                    ->where('status', true)
                    ->with('category')
                    ->orderBy('stock')
                    ->paginate(50),
            ];
        });

        return view('pages.dashboard.index', $data);
    }
}
