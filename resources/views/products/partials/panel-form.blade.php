@php
    $isEdit = ($mode ?? '') === 'edit';
@endphp

<div class="p-6">
    <div class="flex items-start justify-between gap-4">
        <h2 class="text-xl font-semibold leading-tight">{{ $title }}</h2>

        <a href="{{ route('products.index') }}"
           class="inline-flex h-9 w-9 items-center justify-center rounded hover:bg-slate-600/70"
           title="Закрыть">
            ✕
        </a>
    </div>

    @if ($errors->any())
        <div class="mt-4 rounded border border-rose-300 bg-rose-50 px-4 py-3 text-rose-900 text-sm">
            <div class="font-semibold mb-1">Проверь поля формы:</div>
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="mt-6 space-y-4" action="{{ $action }}" method="POST" id="productForm">
        @csrf
        @if(($method ?? 'POST') !== 'POST')
            @method($method)
        @endif

        {{-- Article --}}
        <div>
            <label class="block text-sm text-slate-300 mb-1">Артикул</label>
            <input name="article" value="{{ $form['article'] }}"
                   class="w-full rounded bg-slate-600/40 border border-slate-500 px-3 py-2 text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500"
                   placeholder="mtokb2">
            @error('article')
            <div class="mt-1 text-sm text-rose-300">{{ $message }}</div>
            @enderror
        </div>

        {{-- Name --}}
        <div>
            <label class="block text-sm text-slate-300 mb-1">Название</label>
            <input name="name" value="{{ $form['name'] }}"
                   class="w-full rounded bg-slate-600/40 border border-slate-500 px-3 py-2 text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500"
                   placeholder="MTOK-B2/216-1KT3645-K">
            @error('name')
            <div class="mt-1 text-sm text-rose-300">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status --}}
        <div>
            <label class="block text-sm text-slate-300 mb-1">Статус</label>
            <select name="status"
                    class="w-full rounded bg-slate-600/40 border border-slate-500 px-3 py-2 text-slate-100 focus:outline-none focus:ring-2 focus:ring-red-500">
                <option value="available" @selected(($form['status'] ?? 'available') === 'available')>Доступен</option>
                <option value="unavailable" @selected(($form['status'] ?? '') === 'unavailable')>Не доступен</option>
            </select>
            @error('status')
            <div class="mt-1 text-sm text-rose-300">{{ $message }}</div>
            @enderror
        </div>

        {{-- Attributes --}}
        <div class="pt-2">
            <div class="flex items-center justify-between">
                <div class="text-sm text-slate-300">Атрибуты</div>

                <button type="button" id="addAttrBtn"
                        class="text-sm text-slate-100 hover:text-white">
                    + Добавить атрибут
                </button>
            </div>

            <div class="mt-3 space-y-2" id="attrsContainer">
                @foreach($rows as $i => $row)
                    <div class="grid grid-cols-12 gap-2 attr-row">
                        <div class="col-span-5">
                            <input name="data[{{ $i }}][key]" value="{{ $row['key'] ?? '' }}"
                                   class="w-full rounded bg-slate-600/40 border border-slate-500 px-3 py-2 text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500"
                                   placeholder="Название">
                        </div>
                        <div class="col-span-6">
                            <input name="data[{{ $i }}][value]" value="{{ $row['value'] ?? '' }}"
                                   class="w-full rounded bg-slate-600/40 border border-slate-500 px-3 py-2 text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500"
                                   placeholder="Значение">
                        </div>
                        <div class="col-span-1 flex items-center justify-end">
                            <button type="button" class="remove-attr h-9 w-9 rounded hover:bg-slate-600/70" title="Удалить">
                                🗑
                            </button>
                        </div>

                        {{-- точечные ошибки на строку --}}
                        <div class="col-span-12 -mt-1">
                            @error("data.$i.key")
                            <div class="text-sm text-rose-300">{{ $message }}</div>
                            @enderror
                            @error("data.$i.value")
                            <div class="text-sm text-rose-300">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="inline-flex items-center rounded bg-red-600 px-5 py-2 text-sm font-medium text-white hover:bg-red-700">
                {{ $buttonText }}
            </button>
        </div>
    </form>
</div>

<template id="attrTemplate">
    <div class="grid grid-cols-12 gap-2 attr-row">
        <div class="col-span-5">
            <input name="data[__INDEX__][key]"
                   class="w-full rounded bg-slate-600/40 border border-slate-500 px-3 py-2 text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500"
                   placeholder="Название">
        </div>
        <div class="col-span-6">
            <input name="data[__INDEX__][value]"
                   class="w-full rounded bg-slate-600/40 border border-slate-500 px-3 py-2 text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500"
                   placeholder="Значение">
        </div>
        <div class="col-span-1 flex items-center justify-end">
            <button type="button" class="remove-attr h-9 w-9 rounded hover:bg-slate-600/70" title="Удалить">
                🗑
            </button>
        </div>
    </div>
</template>

<script>
(function () {
    const container = document.getElementById('attrsContainer');
    const addBtn = document.getElementById('addAttrBtn');
    const tpl = document.getElementById('attrTemplate');

    if (!container || !addBtn || !tpl) return;

    let index = container.querySelectorAll('.attr-row').length;

    addBtn.addEventListener('click', () => {
        const html = tpl.innerHTML.replaceAll('__INDEX__', String(index));
        index += 1;
        container.insertAdjacentHTML('beforeend', html);
    });

    container.addEventListener('click', (e) => {
        const btn = e.target.closest('.remove-attr');
        if (!btn) return;
        const row = btn.closest('.attr-row');
        if (row) row.remove();
    });
})();
</script>
