@php
    $product = $product ?? null;
    $submitLabel = $submitLabel ?? 'Save Product';
    $categoryOptions = $categories->pluck('name', 'id')->all();
@endphp

<div class="space-y-6">
    <x-ui.select-field
        name="category_id"
        label="Category"
        :options="$categoryOptions"
        :selected="$product?->category_id"
        placeholder="Select a category"
        required
    />

    <x-ui.form-field
        name="name"
        label="Product Name"
        :value="$product?->name"
        placeholder="Example: Wireless Headphones"
        required
    />

    <x-ui.textarea-field
        name="description"
        label="Description"
        :value="$product?->description"
        placeholder="Write a clear product description"
        required
    />

    <div class="grid gap-6 sm:grid-cols-2">
        <x-ui.form-field
            name="price"
            label="Price"
            type="number"
            :value="$product?->price"
            min="0"
            step="0.01"
            placeholder="0.00"
            required
        />

        <x-ui.form-field
            name="stock"
            label="Stock"
            type="number"
            :value="$product?->stock"
            min="0"
            step="1"
            placeholder="0"
            required
        />
    </div>

    <div class="grid gap-4 sm:grid-cols-[8rem_1fr] sm:items-start">
        <div>
            @if ($product?->image_url)
                <img
                    src="{{ $product->image_url }}"
                    alt="{{ $product->name }} product image"
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
            label="Product Image"
            accept="image/jpeg,image/png,image/webp"
            help="Upload a JPG, PNG, or WebP image up to 2 MB."
        />
    </div>

    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
        <label class="inline-flex items-center gap-3">
            <input
                type="checkbox"
                name="status"
                value="1"
                @checked(old('status', $product?->status ?? true))
                class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
            >
            <span class="text-sm font-medium text-slate-700">Product is active</span>
        </label>
    </div>

    <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-6">
        <x-ui.button :href="route('product.list')" variant="secondary">
            Cancel
        </x-ui.button>

        <x-ui.button type="submit">
            {{ $submitLabel }}
        </x-ui.button>
    </div>
</div>
