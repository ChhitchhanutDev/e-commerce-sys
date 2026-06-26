@extends('layouts.app')

@section('title', $user->name)
@section('eyebrow', 'Administration')
@section('page-title', $user->name)

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <x-ui.card class="p-6">
        <div class="flex items-center gap-4">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-blue-100 text-blue-700 text-xl font-bold">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <h2 class="text-xl font-semibold text-slate-900">{{ $user->name }}</h2>
                <p class="text-sm text-slate-500">{{ $user->email }}</p>
            </div>
        </div>

        <dl class="mt-8 grid gap-4 sm:grid-cols-3">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Role</dt>
                <dd class="mt-1">
                    <span @class([
                        'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold',
                        'bg-purple-100 text-purple-700' => $user->role === 'admin',
                        'bg-blue-100 text-blue-700' => $user->role === 'user',
                    ])>
                        {{ ucfirst($user->role) }}
                    </span>
                </dd>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status</dt>
                <dd class="mt-1">
                    <span @class([
                        'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold',
                        'bg-green-100 text-green-700' => $user->is_active,
                        'bg-red-100 text-red-700' => !$user->is_active,
                    ])>
                        {{ $user->is_active ? 'Active' : 'Suspended' }}
                    </span>
                </dd>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Orders</dt>
                <dd class="mt-1 text-sm font-medium text-slate-900">{{ $user->orders_count }}</dd>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Joined</dt>
                <dd class="mt-1 text-sm text-slate-900">{{ $user->created_at->format('F j, Y') }}</dd>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email Verified</dt>
                <dd class="mt-1 text-sm text-slate-900">
                    {{ $user->email_verified_at ? $user->email_verified_at->format('F j, Y') : 'Not verified' }}
                </dd>
            </div>
        </dl>

        <div class="mt-6 flex flex-wrap gap-3">
            <x-ui.button :href="route('user.list')" variant="secondary">
                Back to Users
            </x-ui.button>

            @if ($user->id !== auth()->id())
                <form method="POST" action="{{ route('user.suspend', $user) }}">
                    @csrf
                    @method('PATCH')

                    <x-ui.button type="submit" variant="{{ $user->is_active ? 'danger' : 'primary' }}">
                        {{ $user->is_active ? 'Suspend User' : 'Activate User' }}
                    </x-ui.button>
                </form>
            @endif
        </div>
    </x-ui.card>

    <div class="mt-8">
        <h2 class="text-lg font-semibold text-slate-900">Order History</h2>

        <x-ui.card class="mt-4 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Order #</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Date</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-600">
                                    ${{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    <span @class([
                                        'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold',
                                        'bg-green-100 text-green-700' => $order->status === 'completed',
                                        'bg-amber-100 text-amber-700' => $order->status === 'pending',
                                        'bg-red-100 text-red-700' => $order->status === 'cancelled',
                                    ])>
                                        {{ ucfirst($order->status) }}
                                    </span>
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
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-500">
                                    No orders placed yet.
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
    </div>
@endsection
