@php
    /** @var \App\Models\Product|null $product **/
    $isEdit = isset($product);
    $role = config('products.role');
@endphp

<div class="space-y-4">
    <div>
        <label class="block text-sm mb-1" for="name">Name</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $product->name ?? '') }}"
            class="w-full rounded border px-3 py-2 text-sm"
            required
        >
    </div>

    <div>
        <label class="block text-sm mb-1" for="article">Article</label>
        <input
            type="text"
            id="article"
            name="article"
            value="{{ old('article', $product->article ?? '') }}"
            class="w-full rounded border px-3 py-2 text-sm
            {{ $role !== 'admin' && $isEdit ? 'bg-slate-100 cursor-not-allowed' : '' }}"
            {{ $role !== 'admin' && $isEdit ? 'readonly' : '' }}
            required
        >
        @if ($role !== 'admin' && $isEdit)
            <p class="mt-1 text-xs text-slate-500">
                Only admin can change article.
            </p>
        @endif
    </div>

    <div>
        <label class="block text-sm mb-1" for="status">Status</label>
        <select
            id="status"
            name="status"
            class="w-full rounded border px-3 py-2 text-sm"
            required
        >
            @php
                $statusValue = old('status', $product->status ?? 'available');
            @endphp
            <option value="available" {{ $statusValue === 'available' ? 'selected' : '' }}>Available</option>
            <option value="unavailable" {{ $statusValue === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1" for="data_color">Color</label>
            <input
                type="text"
                id="data_color"
                name="data[color]"
                value="{{ old('data.color', $product->data['color'] ?? '') }}"
                class="w-full rounded border px-3 py-2 text-sm"
            >
        </div>

        <div>
            <label class="block text-sm mb-1" for="data_size">Size</label>
            <input
                type="text"
                id="data_size"
                name="data[size]"
                value="{{ old('data.size', $product->data['size'] ?? '') }}"
                class="w-full rounded border px-3 py-2 text-sm"
            >
        </div>
    </div>
</div>
