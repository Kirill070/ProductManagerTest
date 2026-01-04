@php
    $statusLabel = $product->status === 'available' ? 'Доступен' : 'Не доступен';
@endphp

<div class="p-6">
    <div class="flex items-start justify-between gap-4">
        <h2 class="text-xl font-semibold leading-tight">{{ $product->name }}</h2>

        <div class="flex items-center gap-2">
            <a href="{{ route('products.edit', $product) }}"
               class="inline-flex h-9 w-9 items-center justify-center rounded hover:bg-slate-600/70"
               title="Редактировать">
                ✎
            </a>

            <form action="{{ route('products.destroy', $product) }}" method="POST"
                  onsubmit="return confirm('Удалить продукт?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex h-9 w-9 items-center justify-center rounded hover:bg-slate-600/70"
                        title="Удалить">
                    🗑
                </button>
            </form>

            <a href="{{ route('products.index') }}"
               class="inline-flex h-9 w-9 items-center justify-center rounded hover:bg-slate-600/70"
               title="Закрыть">
                ✕
            </a>
        </div>
    </div>

    <dl class="mt-6 space-y-4 text-sm">
        <div class="grid grid-cols-3 gap-4">
            <dt class="text-slate-300">Артикул</dt>
            <dd class="col-span-2">{{ $product->article }}</dd>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <dt class="text-slate-300">Название</dt>
            <dd class="col-span-2">{{ $product->name }}</dd>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <dt class="text-slate-300">Статус</dt>
            <dd class="col-span-2">{{ $statusLabel }}</dd>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <dt class="text-slate-300">Атрибуты</dt>
            <dd class="col-span-2">
                @if(is_array($product->data) && count($product->data))
                    @foreach($product->data as $k => $v)
                        <div>{{ $k }}: {{ $v }}</div>
                    @endforeach
                @else
                    <span class="text-slate-300">—</span>
                @endif
            </dd>
        </div>
    </dl>
</div>
