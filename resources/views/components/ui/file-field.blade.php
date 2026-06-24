@props([
    'name',
    'label',
    'accept' => null,
    'help' => null,
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">
        {{ $label }}
    </label>

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="file"
        @if ($accept) accept="{{ $accept }}" @endif
        {{ $attributes->merge(['class' => 'mt-2 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20']) }}
    >

    @if ($help)
        <p class="mt-2 text-sm text-slate-500">{{ $help }}</p>
    @endif

    <x-ui.input-error :name="$name" />
</div>
