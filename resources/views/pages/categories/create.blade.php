@extends('layouts.app')

@section('title', 'Create Category')
@section('eyebrow', 'Category Management')
@section('page-title', 'Create Category')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Category details</h2>
                <p class="mt-1 text-sm text-slate-500">Add a new product category to the catalog.</p>
            </div>

            <x-ui.button :href="route('cate.list')" variant="secondary">
                Back to Categories
            </x-ui.button>
        </div>

        <x-ui.card class="p-6">
            <form method="POST" action="{{ route('cate.store') }}" enctype="multipart/form-data" novalidate>
                @csrf

                @include('pages.categories._form', [
                    'submitLabel' => 'Create Category',
                ])
            </form>
        </x-ui.card>
    </div>
@endsection
