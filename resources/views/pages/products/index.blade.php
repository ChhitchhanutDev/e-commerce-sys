@extends('layouts.app')

@section('title', 'Products')
@section('eyebrow', 'Catalog')
@section('page-title', 'Products')

@section('content')
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Product Management</h2>
            <p class="mt-1 text-sm text-slate-500">Create, update, and remove catalog products.</p>
        </div>

        <x-ui.button :href="route('product.create')">
            Add Product
        </x-ui.button>
    </div>

    <x-ui.card class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Image</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Product</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Category</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Price</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Stock</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($products as $product)
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                {{ $loop->iteration }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($product->image_url)
                                    <img
                                        src="{{ $product->image_url }}"
                                        alt="{{ $product->name }} product image"
                                        class="h-12 w-12 rounded-lg border border-slate-200 object-cover"
                                    >
                                @else
                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 text-xs font-semibold text-slate-400">
                                        —
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-900">
                                    {{ $product->name }}
                                </span>
                                <div class="mt-1 max-w-xl text-sm text-slate-500">{{ $product->description }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                {{ $product->category?->name ?? 'Uncategorized' }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-600">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-600">
                                {{ $product->stock }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                <span @class([
                                    'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold',
                                    'bg-green-100 text-green-700' => $product->status,
                                    'bg-slate-100 text-slate-600' => ! $product->status,
                                ])>
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                <div class="flex justify-end gap-2">
                                    <x-ui.button :href="route('product.edit', $product)" variant="warning">
                                        Edit
                                    </x-ui.button>

                                    <form method="POST" action="{{ route('product.destroy', $product) }}">
                                        @csrf
                                        @method('DELETE')

                                        <x-ui.button type="submit" variant="danger">
                                            Delete
                                        </x-ui.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <p class="text-sm font-medium text-slate-900">No products found.</p>
                                <p class="mt-1 text-sm text-slate-500">Create your first product to start building the catalog.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
@endsection
