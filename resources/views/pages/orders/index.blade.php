@extends('layouts.app')


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof window.Echo !== 'undefined') {
        window.Echo.channel('orders')
            .listen('.App\\Events\\OrderStatusUpdated', function (e) {
                var row = document.querySelector('[data-order-id="' + e.id + '"]');
                if (!row) return;

                var badge = row.querySelector('.order-status-badge');
                if (badge) {
                    badge.textContent = e.status.charAt(0).toUpperCase() + e.status.slice(1);
                    badge.className = 'rounded-full px-2.5 py-1 text-xs font-semibold ' + statusClass(e.status);
                }

                var select = row.querySelector('.status-select');
                if (select && select.value !== e.status) {
                    select.value = e.status;
                    select.className = select.className.replace(/border-\w+-\d+\sbg-\w+-\d+\stext-\w+-\d+/, '') + ' ' + statusSelectClass(e.status);
                }
            });

        function statusClass(status) {
            return {
                'completed': 'bg-green-100 text-green-700',
                'pending': 'bg-amber-100 text-amber-700',
                'cancelled': 'bg-red-100 text-red-700',
                'delivered': 'bg-blue-100 text-blue-700'
            }[status] || '';
        }

        function statusSelectClass(status) {
            return {
                'completed': 'border-green-200 bg-green-50 text-green-700',
                'pending': 'border-amber-200 bg-amber-50 text-amber-700',
                'cancelled': 'border-red-200 bg-red-50 text-red-700',
                'delivered': 'border-blue-200 bg-blue-50 text-blue-700'
            }[status] || '';
        }
    }
});
</script>
@endpush

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <x-ui.card class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Order #</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Customer</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Total</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Date</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($orders as $order)
                        <tr data-order-id="{{ $order->id }}">
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">
                                #{{ $order->id }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                {{ $order->user?->name ?? 'N/A' }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-600">
                                ${{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                <form method="POST" action="{{ route('order.status', $order) }}" class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')

                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="status-select rounded-lg border text-xs font-semibold px-2.5 py-1 outline-none focus:ring-2 focus:ring-blue-500/20
                                        {{ $order->status === 'completed' ? 'border-green-200 bg-green-50 text-green-700' : '' }}
                                        {{ $order->status === 'pending' ? 'border-amber-200 bg-amber-50 text-amber-700' : '' }}
                                        {{ $order->status === 'cancelled' ? 'border-red-200 bg-red-50 text-red-700' : '' }}
                                        {{ $order->status === 'delivered' ? 'border-blue-200 bg-blue-50 text-blue-700' : '' }}"
                                    >
                                        <option value="pending" @selected($order->status === 'pending')>Pending</option>
                                        <option value="completed" @selected($order->status === 'completed')>Completed</option>
                                        <option value="delivered" @selected($order->status === 'delivered')>Delivered</option>
                                        <option value="cancelled" @selected($order->status === 'cancelled')>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                {{ $order->created_at->format('M j, Y') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                <x-ui.button :href="route('order.show', $order)" variant="secondary">
                                    View
                                </x-ui.button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <p class="text-sm font-medium text-slate-900">No orders found.</p>
                                <p class="mt-1 text-sm text-slate-500">Orders will appear here once customers place them.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $orders->links() }}
            </div>
        @endif
    </x-ui.card>
@endsection
