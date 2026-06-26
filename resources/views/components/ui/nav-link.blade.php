@props([
    'href',
    'active' => false,
])

<a
    href="{{ $href }}"
    @class([
        'block rounded-lg px-4 py-2.5 text-sm font-medium transition',
        'bg-blue-100 text-slate-700' => $active,
        'text-slate-500 hover:bg-blue-100/50 hover:text-slate-700' => ! $active,
    ])
>
    {{ $slot }}
</a>
