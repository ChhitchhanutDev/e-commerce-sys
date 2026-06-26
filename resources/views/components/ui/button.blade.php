@props([
    'type' => 'button',
    'variant' => 'primary',
    'href' => null,
])

@php
    $classes = match ($variant) {
        'primary'   => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        'secondary' => 'bg-slate-200 text-slate-700 hover:bg-slate-300 focus:ring-slate-400',
        'danger'    => 'bg-red-200 text-red-700 hover:bg-red-300 focus:ring-red-400',
        'warning'   => 'bg-amber-500 text-slate-700 hover:bg-amber-600 focus:ring-amber-400',
        default     => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
    };
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
