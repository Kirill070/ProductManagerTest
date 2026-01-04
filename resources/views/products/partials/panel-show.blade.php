@php
    $statusLabel = $product->status === 'available' ? 'Доступен' : 'Не доступен';
@endphp

<div class="h-full bg-[#363F50] text-white">
    <div class="px-[32px] pt-[26px]">
        <div class="flex items-start justify-between">
            <h2 class="text-[30px] font-semibold leading-tight">
                {{ $product->name }}
            </h2>

            <div class="flex items-start gap-4">
                <div class="flex">
                    <a href="{{ route('products.edit', $product) }}"
                       class="h-[44px] w-[44px] bg-[#202430] flex items-center justify-center"
                       title="Редактировать">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M12 20h9" stroke="#9AA3AD" stroke-width="2" stroke-linecap="round"/>
                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4 11.5-11.5Z"
                                  stroke="#9AA3AD" stroke-width="2" stroke-linejoin="round"/>
                        </svg>
                    </a>

                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                          onsubmit="return confirm('Удалить продукт?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="h-[44px] w-[44px] bg-[#202430] flex items-center justify-center border-l border-[#363F50]"
                                title="Удалить">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M3 6h18" stroke="#9AA3AD" stroke-width="2" stroke-linecap="round"/>
                                <path d="M8 6V4h8v2" stroke="#9AA3AD" stroke-width="2" stroke-linecap="round"/>
                                <path d="M6 6l1 16h10l1-16" stroke="#9AA3AD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <a href="{{ route('products.index') }}" class="opacity-70 hover:opacity-100" title="Закрыть">
                    <svg width="44" height="44" viewBox="0 0 24 24" fill="none">
                        <path d="M6 6L18 18M18 6L6 18" stroke="#C3C3C3" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="mt-10 space-y-7 text-[22px]">
            <div class="grid grid-cols-[160px_1fr] gap-8 items-start">
                <div class="text-[#A0A8B3]">Артикул</div>
                <div>{{ $product->article }}</div>
            </div>

            <div class="grid grid-cols-[160px_1fr] gap-8 items-start">
                <div class="text-[#A0A8B3]">Название</div>
                <div>{{ $product->name }}</div>
            </div>

            <div class="grid grid-cols-[160px_1fr] gap-8 items-start">
                <div class="text-[#A0A8B3]">Статус</div>
                <div>{{ $statusLabel }}</div>
            </div>

            <div class="grid grid-cols-[160px_1fr] gap-8 items-start">
                <div class="text-[#A0A8B3]">Атрибуты</div>
                <div class="text-[22px] leading-7">
                    @if(is_array($product->data) && count($product->data))
                        @foreach($product->data as $k => $v)
                            <div>{{ $k }}: {{ $v }}</div>
                        @endforeach
                    @else
                        <span class="text-[#A0A8B3]">—</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
