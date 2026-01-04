@php
    $isEdit = ($mode ?? '') === 'edit';

    $inputBase = 'bg-white rounded-[10px] h-[64px] px-6 text-[20px] text-black outline-none w-full';
    $labelBase = 'block text-white text-[18px] mb-3';
@endphp

<div class="h-full bg-[#363F50]">
    <div class="px-[32px] pt-[26px] pb-[40px]">
        <div class="flex items-start justify-between">
            <h2 class="text-white text-[44px] font-semibold leading-tight">
                {{ $title }}
            </h2>

            <a href="{{ route('products.index') }}" class="opacity-70 hover:opacity-100" title="Закрыть">
                <svg width="44" height="44" viewBox="0 0 24 24" fill="none">
                    <path d="M6 6L18 18M18 6L6 18" stroke="#C3C3C3" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </a>
        </div>

        <form class="mt-10" action="{{ $action }}" method="POST" id="productForm">
            @csrf
            @if(($method ?? 'POST') !== 'POST')
                @method($method)
            @endif

            <div class="max-w-[980px] space-y-8">
                <div>
                    <label class="{{ $labelBase }}">Артикул</label>
                    <input name="article" value="{{ $form['article'] }}" class="{{ $inputBase }}">
                    @error('article')
                        <div class="mt-2 text-[#FF8080] text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="{{ $labelBase }}">Название</label>
                    <input name="name" value="{{ $form['name'] }}" class="{{ $inputBase }}">
                    @error('name')
                        <div class="mt-2 text-[#FF8080] text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="{{ $labelBase }}">Статус</label>

                    <div class="relative">
                        <select name="status"
                                class="{{ $inputBase }} appearance-none pr-14">
                            <option value="available" @selected(($form['status'] ?? 'available') === 'available')>Доступен</option>
                            <option value="unavailable" @selected(($form['status'] ?? '') === 'unavailable')>Не доступен</option>
                        </select>

                        <div class="pointer-events-none absolute right-5 top-1/2 -translate-y-1/2">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                <path d="M6 9l6 6 6-6" stroke="#BDBDBD" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>

                    @error('status')
                        <div class="mt-2 text-[#FF8080] text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="pt-2">
                    <div class="text-white text-[32px] font-semibold">Атрибуты</div>

                    <div class="mt-8 space-y-7" id="attrsContainer">
                        @foreach($rows as $i => $row)
                            <div class="attr-row">
                                <div class="flex gap-6 items-end">
                                    <div class="w-[460px] max-w-full">
                                        <label class="{{ $labelBase }}">Название</label>
                                        <input name="data[{{ $i }}][key]" value="{{ $row['key'] ?? '' }}" class="{{ $inputBase }} h-[62px] text-[18px]">
                                        @error("data.$i.key")
                                            <div class="mt-2 text-[#FF8080] text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="w-[460px] max-w-full">
                                        <label class="{{ $labelBase }}">Значение</label>
                                        <input name="data[{{ $i }}][value]" value="{{ $row['value'] ?? '' }}" class="{{ $inputBase }} h-[62px] text-[18px]">
                                        @error("data.$i.value")
                                            <div class="mt-2 text-[#FF8080] text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="button" class="remove-attr mb-[6px] opacity-60 hover:opacity-100" title="Удалить">
                                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                                            <path d="M3 6h18" stroke="#9AA3AD" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M8 6V4h8v2" stroke="#9AA3AD" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M6 6l1 16h10l1-16" stroke="#9AA3AD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M10 11v6M14 11v6" stroke="#9AA3AD" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="addAttrBtn"
                            class="mt-6 text-[#0EC5FF] underline text-[18px]">
                        + Добавить атрибут
                    </button>
                </div>

                <div class="pt-6">
                    <button type="submit"
                            class="h-[76px] w-[320px] rounded-[10px] bg-[#0EC5FF] text-white text-[22px] font-semibold">
                        {{ $buttonText }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<template id="attrTemplate">
    <div class="attr-row">
        <div class="flex gap-6 items-end">
            <div class="w-[460px] max-w-full">
                <label class="block text-white text-[18px] mb-3">Название</label>
                <input name="data[__INDEX__][key]" class="bg-white rounded-[10px] h-[62px] px-6 text-[18px] text-black outline-none w-full">
            </div>

            <div class="w-[460px] max-w-full">
                <label class="block text-white text-[18px] mb-3">Значение</label>
                <input name="data[__INDEX__][value]" class="bg-white rounded-[10px] h-[62px] px-6 text-[18px] text-black outline-none w-full">
            </div>

            <button type="button" class="remove-attr mb-[6px] opacity-60 hover:opacity-100" title="Удалить">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                    <path d="M3 6h18" stroke="#9AA3AD" stroke-width="2" stroke-linecap="round"/>
                    <path d="M8 6V4h8v2" stroke="#9AA3AD" stroke-width="2" stroke-linecap="round"/>
                    <path d="M6 6l1 16h10l1-16" stroke="#9AA3AD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 11v6M14 11v6" stroke="#9AA3AD" stroke-width="2" stroke-linecap="round"/>
                </svg>
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
