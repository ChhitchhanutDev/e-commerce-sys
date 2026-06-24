@extends('layouts.app')

@section('title', 'Dashboard')
@section('eyebrow', 'Overview')
@section('page-title', 'Dashboard')

@section('content')
    <div class="grid gap-6 md:grid-cols-2">
        <x-ui.card class="p-6">
            <h2 class="text-lg font-semibold text-slate-900">Category Management</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                Create, update, and organize product categories.
            </p>

            <div class="mt-5">
                <x-ui.button :href="route('cate.list')">
                    Manage Categories
                </x-ui.button>
            </div>
        </x-ui.card>

        <x-ui.card class="p-6">
            <h2 class="text-lg font-semibold text-slate-900">Product Management</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                Review products, stock levels, prices, and status.
            </p>

            <div class="mt-5">
                <x-ui.button :href="route('product.list')">
                    Manage Products
                </x-ui.button>
            </div>
        </x-ui.card>
    </div>
@endsection
