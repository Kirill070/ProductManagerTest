@extends('layouts.app')

@section('content')
    @php
        $statusLabel = $product->status === 'available' ? 'Доступен' : 'Не доступен';
        $color = $product->data['color'] ?? null;
        $size  = $product->data['size'] ?? null;
        $attrsText = trim(
            ($color ? 'Цвет: ' . $color : '') . ($size ? "\nРазмер: " . $size : '')
        );
    @endphp

    <div class="pt-[17px] pl-0">
        <div class="relative w-[630px] h-[387px] bg-[#374050] border border-black">

            {{-- Title --}}
            <div class="absolute left-[12px] top-[27px] text-white font-bold text-[20px] leading-[11px]">
                {{ $product->name }}
            </div>

            {{-- Actions (edit, delete) --}}
            <a href="{{ route('products.edit', $product) }}"
               class="absolute left-[545px] top-[23px] w-[20px] h-[20px] bg-black/40 flex items-center justify-center"
               title="Редактировать">
                {{-- pencil icon --}}
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25Z" fill="rgba(196,196,196,0.7)"/>
                    <path d="M20.71 7.04a1.0 1.0 0 0 0 0-1.41l-2.34-2.34a1.0 1.0 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83Z"
                          fill="rgba(196,196,196,0.7)"/>
                </svg>
            </a>

            <form action="{{ route('products.destroy', $product) }}"
                  method="POST"
                  class="absolute left-[567px] top-[23px]"
                  onsubmit="return confirm('Удалить продукт?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-[20px] h-[20px] bg-black/40 flex items-center justify-center"
                        title="Удалить">
                    {{-- trash icon --}}
                    <svg width="10" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M7 21a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V7H7v14Zm12-16h-3.5l-1-1h-5l-1 1H5v2h14V5Z"
                              fill="rgba(196,196,196,0.7)"/>
                    </svg>
                </button>
            </form>

            {{-- Close --}}
            <a href="{{ route('products.index') }}"
               class="absolute left-[595px] top-[18px] w-[30px] h-[30px] flex items-center justify-center"
               title="Закрыть">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" aria-hidden="true">
                    <path d="M9 9L21 21" stroke="#C4C4C4" stroke-width="2" stroke-linecap="square"/>
                    <path d="M21 9L9 21" stroke="#C4C4C4" stroke-width="2" stroke-linecap="square"/>
                </svg>
            </a>

            {{-- Fields --}}
            <div class="absolute left-[12px] top-[68px] text-[11px] leading-[11px] text-white/70">Артикул</div>
            <div class="absolute left-[91px] top-[68px] text-[11px] leading-[11px] text-white">
                {{ $product->article }}
            </div>

            <div class="absolute left-[12px] top-[97px] text-[11px] leading-[11px] text-white/70">Название</div>
            <div class="absolute left-[91px] top-[97px] text-[11px] leading-[11px] text-white">
                {{ $product->name }}
            </div>

            <div class="absolute left-[12px] top-[126px] text-[11px] leading-[11px] text-white/70">Статус</div>
            <div class="absolute left-[91px] top-[126px] text-[11px] leading-[11px] text-white">
                {{ $statusLabel }}
            </div>

            <div class="absolute left-[12px] top-[155px] text-[11px] leading-[11px] text-white/70">Атрибуты</div>
            <div class="absolute left-[91px] top-[155px] text-[11px] leading-[13px] text-white whitespace-pre-line">
                {{ $attrsText !== '' ? $attrsText : '—' }}
            </div>
        </div>
    </div>
@endsection
