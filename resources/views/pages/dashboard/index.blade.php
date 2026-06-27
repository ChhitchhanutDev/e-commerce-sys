@extends('layouts.app')


@section('content')
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <x-ui.card class="p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Orders</p>
                    <p class="text-xl font-bold text-slate-900">{{ $totalOrders }}</p>
                </div>
            </div>
            <a href="{{ route('order.list') }}" class="mt-3 block text-xs font-medium text-blue-600 hover:text-blue-700">View Orders &rarr;</a>
        </x-ui.card>

        <x-ui.card class="p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 text-green-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Revenue</p>
                    <p class="text-xl font-bold text-slate-900">${{ number_format($totalRevenue, 0) }}</p>
                </div>
            </div>
            <a href="{{ route('order.list') }}" class="mt-3 block text-xs font-medium text-green-600 hover:text-green-700">View Orders &rarr;</a>
        </x-ui.card>

        <x-ui.card class="p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Customers</p>
                    <p class="text-xl font-bold text-slate-900">{{ $totalCustomers }}</p>
                </div>
            </div>
            <a href="{{ route('user.list') }}" class="mt-3 block text-xs font-medium text-purple-600 hover:text-purple-700">View Users &rarr;</a>
        </x-ui.card>

        <x-ui.card class="p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Products</p>
                    <p class="text-xl font-bold text-slate-900">{{ $totalProducts }}</p>
                </div>
            </div>
            <a href="{{ route('product.list') }}" class="mt-3 block text-xs font-medium text-indigo-600 hover:text-indigo-700">View Products &rarr;</a>
        </x-ui.card>

        <x-ui.card class="p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Pending</p>
                    <p class="text-xl font-bold text-slate-900">{{ $pendingOrders }}</p>
                </div>
            </div>
            <a href="{{ route('order.list') }}" class="mt-3 block text-xs font-medium text-amber-600 hover:text-amber-700">View Orders &rarr;</a>
        </x-ui.card>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <x-ui.card class="overflow-hidden">
            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Best Selling Products</h2>
                <p class="mt-0.5 text-sm text-slate-500">Top products by units sold from completed orders.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Product</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Category</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Sold</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($bestSelling as $item)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-400">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">
                                    <a href="{{ route('product.edit', $item->product) }}" class="text-blue-600 hover:text-blue-700">
                                        {{ $item->product?->name ?? 'Deleted' }}
                                    </a>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                    {{ $item->product?->category?->name ?? '—' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium text-slate-900">
                                    {{ $item->sold }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-600">
                                    ${{ number_format($item->revenue, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-400">
                                    No sales data yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-ui.card>

        <x-ui.card class="overflow-hidden">
            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Low Stock Alert</h2>
                <p class="mt-0.5 text-sm text-slate-500">Active products running low on inventory.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Product</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Category</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Stock</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Price</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($lowStock as $product)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">
                                    <a href="{{ route('product.edit', $product) }}" class="text-blue-600 hover:text-blue-700">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                    {{ $product->category?->name ?? '—' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-bold
                                    {{ $product->stock <= 2 ? 'text-red-600' : 'text-amber-600' }}">
                                    {{ $product->stock }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-600">
                                    ${{ number_format($product->price, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-400">
                                    All products are well stocked.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($lowStock->count() > 5)
                <div class="border-t border-slate-100 px-6 py-3">
                    <a href="{{ route('product.list') }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">View all products &rarr;</a>
                </div>
            @endif
        </x-ui.card>
    </div>
@endsection
