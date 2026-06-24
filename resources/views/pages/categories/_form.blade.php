@php
    $category = $category ?? null;
    $submitLabel = $submitLabel ?? 'Save Category';
@endphp

<div class="space-y-6">
    <x-ui.form-field
        name="name"
        label="Category Name"
        :value="$category?->name"
        placeholder="Example: Electronics"
        required
    />

    <x-ui.textarea-field
        name="description"
        label="Description"
        :value="$category?->description"
        placeholder="Write a short category description"
        required
    />

    <div class="grid gap-4 sm:grid-cols-[8rem_1fr] sm:items-start">
        <div>
            @if ($category?->image_url)
                <img
                    src="{{ $category->image_url }}"
                    alt="{{ $category->name }} category image"
                    class="h-28 w-28 rounded-xl border border-slate-200 object-cover"
                >
            @else
                <div class="flex h-28 w-28 items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50 text-xs font-medium uppercase tracking-wide text-slate-400">
                    No Image
                </div>
            @endif
        </div>

        <x-ui.file-field
            name="image"
            label="Category Image"
            accept="image/jpeg,image/png,image/webp"
            help="Upload a JPG, PNG, or WebP image up to 2 MB."
        />
    </div>

    <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-6">
        <x-ui.button :href="route('cate.list')" variant="secondary">
            Cancel
        </x-ui.button>

        <x-ui.button type="submit">
            {{ $submitLabel }}
        </x-ui.button>
    </div>
</div>
