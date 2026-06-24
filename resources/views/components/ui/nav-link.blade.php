@props([
    'href',
    'active' => false,
])

<a
    href="{{ $href }}"
    @class([
        'block rounded-lg px-4 py-2.5 text-sm font-medium transition',
        'bg-white/10 text-white' => $active,
        'text-slate-300 hover:bg-white/10 hover:text-white' => ! $active,
    ])
>
    {{ $slot }}
</a>
