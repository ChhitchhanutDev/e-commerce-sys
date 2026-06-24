@extends('layouts.app')

@section('title', 'Edit Product')
@section('eyebrow', 'Product Management')
@section('page-title', 'Edit Product')

@section('content')
    <div class="max-w-4xl">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Product details</h2>
                <p class="mt-1 text-sm text-slate-500">Update product information and inventory.</p>
            </div>

            <x-ui.button :href="route('product.list')" variant="secondary">
                Back to Products
            </x-ui.button>
        </div>

        <x-ui.card class="p-6">
            <form method="POST" action="{{ route('product.update', $product) }}" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                @include('pages.products._form', [
                    'product' => $product,
                    'categories' => $categories,
                    'submitLabel' => 'Update Product',
                ])
            </form>
        </x-ui.card>
    </div>
@endsection
