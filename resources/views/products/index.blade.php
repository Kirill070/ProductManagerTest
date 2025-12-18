@extends('layouts.app')

@section('content')
    @php
        $buttonTopOffset = 'mt-[27px]';
    @endphp

    <div class="pt-[6px] flex items-start">
        <div>
            <div class="w-[630px] grid items-center h-[25px] px-[18px]"
                 style="grid-template-columns: 152px 150px 151px 177px;">
                <div class="text-[9px] leading-[11px] text-[#6E6E6F] uppercase">АРТИКУЛ</div>
                <div class="text-[9px] leading-[11px] text-[#6E6E6F] uppercase">НАЗВАНИЕ</div>
                <div class="text-[9px] leading-[11px] text-[#6E6E6F] uppercase">СТАТУС</div>
                <div class="text-[9px] leading-[11px] text-[#6E6E6F] uppercase">АТРИБУТЫ</div>
            </div>

            <div class="w-[630px] border-t border-[#C4C4C4] mt-[6px]"></div>

            <div class="w-[630px] bg-white border-x border-[#C4C4C4] border-b border-[#C4C4C4]">
                @forelse($products as $product)
                    @php
                        $statusLabel = $product->status === 'available' ? 'Доступен' : 'Не доступен';
                        $color = $product->data['color'] ?? null;
                        $size  = $product->data['size'] ?? null;
                    @endphp

                    <div class="h-[56px] grid items-center text-[11px] leading-[11px] text-[#6E6E6F] px-[18px]"
                         style="grid-template-columns: 152px 150px 151px 177px;">
                        <div>
                            <a href="{{ route('products.show', $product) }}" class="hover:underline">
                                {{ $product->article }}
                            </a>
                        </div>

                        <div>{{ $product->name }}</div>

                        <div>{{ $statusLabel }}</div>

                        <div class="leading-[13px]">
                            <div>{{ $color ? 'Цвет: '.$color : '—' }}</div>
                            <div>{{ $size ? 'Размер: '.$size : '' }}</div>
                        </div>
                    </div>

                    @if(! $loop->last)
                        <div class="border-t border-[#C4C4C4]"></div>
                    @endif
                @empty
                    <div class="px-0 py-6 text-[11px] text-[#6E6E6F]">Нет продуктов</div>
                @endforelse
            </div>
        </div>

        <div class="flex-1 pr-[31px]">
            <div class="flex justify-end {{ $buttonTopOffset }}">
                <a href="{{ route('products.create') }}"
                   class="w-[136px] h-[30px] rounded-[6px] bg-[#0FC5FF] text-white
                          text-[11px] leading-[11px] font-medium inline-flex items-center justify-center">
                    Добавить
                </a>
            </div>
        </div>
    </div>
@endsection
