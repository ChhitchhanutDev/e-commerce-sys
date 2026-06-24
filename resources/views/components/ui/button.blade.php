@props([
    'type' => 'button',
    'variant' => 'primary',
    'href' => null,
])

@php
    $classes = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        'secondary' => 'bg-slate-200 text-slate-800 hover:bg-slate-300 focus:ring-slate-400',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'warning' => 'bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-500',
    ][$variant];
@endphp

@if ($href)
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-lg px-4 py-2.5 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 {$classes}"]) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-lg px-4 py-2.5 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 {$classes}"]) }}
    >
        {{ $slot }}
    </button>
@endif
