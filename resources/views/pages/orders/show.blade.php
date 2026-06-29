@extends('layouts.app')

@section('title', 'Order #' . $order->id)
@section('eyebrow', 'Commerce')
@section('page-title', 'Order #' . $order->id)

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        <x-ui.card class="p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-slate-900">Order Items</h2>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Product</th>
                            <th scope="col"
                                class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Price</th>
                            <th scope="col"
                                class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Qty</th>
                            <th scope="col"
                                class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($order->items as $item)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-slate-900">
                                    {{ $item->product?->name ?? 'Deleted Product' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-600">
                                    ${{ number_format($item->price, 2) }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-600">
                                    {{ $item->quantity }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-medium text-slate-900">
                                    ${{ number_format($item->subtotal, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">No items in this
                                    order.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-slate-200 bg-slate-50">
                            <td colspan="3" class="px-4 py-3 text-right text-sm font-semibold text-slate-900">Total</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-bold text-slate-900">
                                ${{ number_format($order->total_amount, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </x-ui.card>

        <div class="space-y-6">
            <x-ui.card class="p-6">
                <h2 class="text-lg font-semibold text-slate-900">Customer</h2>

                <dl class="mt-4 space-y-3">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Name</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $order->user?->name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</dt>
                        <dd class="mt-1 text-sm text-slate-500">{{ $order->user?->email ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </x-ui.card>

            <x-ui.card class="p-6">
                <h2 class="text-lg font-semibold text-slate-900">Order Details</h2>

                <dl class="mt-4 space-y-3">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status</dt>
                        <dd class="mt-1">
                            <span @class([
                                'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold',
                                'bg-green-100 text-green-700' => $order->status === 'completed',
                                'bg-amber-100 text-amber-700' => $order->status === 'pending',
                                'bg-red-100 text-red-700' => $order->status === 'cancelled',
                                'bg-blue-100 text-blue-700' => $order->status === 'delivered',
                            ])>
                                {{ ucfirst($order->status) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Placed On:
                            <span class="mt-1 text-sm text-slate-900">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Shipping Address:
                            <span class="mt-1 text-sm text-slate-900">{{ $order->shipping_address }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Contact Number:
                            <span class="mt-1 text-sm text-slate-900">{{ $order->phone_number }}</span>
                        </p>
                    </div>
                </dl>
            </x-ui.card>

            <div class="flex gap-2">
                <x-ui.button :href="route('order.list')" variant="secondary">
                    Back to Orders
                </x-ui.button>
            </div>
        </div>
    </div>
@endsection
