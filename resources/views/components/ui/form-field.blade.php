@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'required' => false,
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">
        {{ $label }}
    </label>

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        @required($required)
        {{ $attributes->merge(['class' => 'mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20']) }}
    >

    <x-ui.input-error :name="$name" />
</div>
