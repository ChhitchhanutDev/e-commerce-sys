@props([
    'name',
    'label',
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'required' => false,
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">
        {{ $label }}
    </label>

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        @required($required)
        {{ $attributes->merge(['class' => 'mt-2 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20']) }}
    >
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach ($options as $value => $label)
            <option value="{{ $value }}" @selected((string) old($name, $selected) === (string) $value)>
                {{ $label }}
            </option>
        @endforeach
    </select>

    <x-ui.input-error :name="$name" />
</div>
