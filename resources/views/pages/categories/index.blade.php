@extends('layouts.app')


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

    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Category Management</h2>
            <p class="mt-1 text-sm text-slate-500">Create, update, and remove product categories.</p>
        </div>

        <x-ui.button :href="route('cate.create')">
            Add Category
        </x-ui.button>
    </div>

    <x-ui.card class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Image</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Description</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                {{ $loop->iteration }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($category->image_url)
                                    <img
                                        src="{{ $category->image_url }}"
                                        alt="{{ $category->name }} category image"
                                        class="h-12 w-12 rounded-lg border border-slate-200 object-cover"
                                    >
                                @else
                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 text-xs font-semibold text-slate-400">
                                        —
                                    </div>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $category->description }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                <div class="flex justify-end gap-2">
                                    <x-ui.button :href="route('cate.edit', $category)" variant="warning">
                                        Edit
                                    </x-ui.button>

                                    <form method="POST" action="{{ route('cate.destroy', $category) }}">
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
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-sm font-medium text-slate-900">No categories found.</p>
                                <p class="mt-1 text-sm text-slate-500">Create your first category to organize products.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categories->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $categories->links() }}
            </div>
        @endif
    </x-ui.card>
@endsection
