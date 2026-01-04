@extends('layouts.app')

@section('title', 'Менеджер продуктов')

@section('header_left')
    <div class="leading-none">
        <div class="text-[12px] font-semibold tracking-widest text-[#E31B23] uppercase">Продукты</div>
        <div class="mt-[22px] h-[2px] w-[86px] bg-[#E31B23]"></div>
    </div>
@endsection

@php
    $panel = $panel ?? null;

    $statusLabel = fn($status) => $status === 'available' ? 'Доступен' : 'Не доступен';

    $form = [
        'article' => old('article', $product->article ?? ''),
        'name' => old('name', $product->name ?? ''),
        'status' => old('status', $product->status ?? 'available'),
    ];

    $rows = old('data');
    if (!is_array($rows)) {
        $rows = [];
        if (($panel === 'edit') && isset($product)) {
            foreach (($product->data ?? []) as $k => $v) {
                $rows[] = ['key' => $k, 'value' => $v];
            }
        }
    }
@endphp

@section('content')
<div class="grid grid-cols-2 min-h-[calc(100vh-120px)]">
    <section class="bg-[#F2F6F9]">
        <div class="bg-white border-b border-[#C3C3C3]">
            <table class="w-full">
                <thead class="bg-[#F2F6F9] border-b border-[#C3C3C3]">
                <tr class="text-left text-[10px] uppercase tracking-wider text-[#A0A8B3] font-semibold">
                    <th class="px-[56px] py-4 w-[180px]">Артикул</th>
                    <th class="px-8 py-4">Название</th>
                    <th class="px-8 py-4 w-[170px]">Статус</th>
                    <th class="px-8 py-4 w-[320px]">Атрибуты</th>
                </tr>
                </thead>

                <tbody>
                @forelse($products as $p)
                    <tr
                        data-href="{{ route('products.show', $p) }}"
                        tabindex="0"
                        role="link"
                        class="cursor-pointer bg-white hover:bg-[#F2F6F9]"
                    >
                        <td class="px-[56px] py-6 text-[14px] text-[#6F7680] border-b border-[#C3C3C3]">
                            {{ $p->article }}
                        </td>
                        <td class="px-8 py-6 text-[14px] text-[#6F7680] border-b border-[#C3C3C3]">
                            {{ $p->name }}
                        </td>
                        <td class="px-8 py-6 text-[14px] text-[#6F7680] border-b border-[#C3C3C3]">
                            {{ $statusLabel($p->status) }}
                        </td>
                        <td class="px-8 py-6 text-[12px] leading-5 text-[#6F7680] border-b border-[#C3C3C3]">
                            @if(is_array($p->data) && count($p->data))
                                @foreach($p->data as $k => $v)
                                    <div>{{ $k }}: {{ $v }}</div>
                                @endforeach
                            @else
                                <span class="text-[#A0A8B3]">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-[56px] py-16 text-[#A0A8B3]">
                            Список продуктов пуст
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <aside class="{{ $panel ? 'bg-[#363F50]' : 'bg-[#F2F6F9]' }}">
        @if(!$panel)
            <div class="flex justify-end pt-[36px] pr-[72px]">
                <a href="{{ route('products.create') }}"
                   class="inline-flex items-center justify-center h-[34px] w-[180px] rounded bg-[#0EC5FF] text-white text-[12px] font-semi">
                    Добавить
                </a>
            </div>
        @else
            @if($panel === 'create')
                @include('products.partials.panel-form', [
                    'mode' => 'create',
                    'title' => 'Добавить продукт',
                    'action' => route('products.store'),
                    'method' => 'POST',
                    'buttonText' => 'Добавить',
                    'form' => $form,
                    'rows' => $rows,
                ])
            @elseif($panel === 'edit' && isset($product))
                @include('products.partials.panel-form', [
                    'mode' => 'edit',
                    'title' => 'Редактировать ' . $product->name,
                    'action' => route('products.update', $product),
                    'method' => 'PUT',
                    'buttonText' => 'Сохранить',
                    'form' => $form,
                    'rows' => $rows,
                    'product' => $product,
                ])
            @elseif($panel === 'show' && isset($product))
                @include('products.partials.panel-show', ['product' => $product])
            @endif
        @endif
    </aside>
</div>

<script>
(function () {
    const isInteractive = (el) => el && el.closest('a,button,form,input,select,textarea,label');

    document.addEventListener('click', (e) => {
        if (isInteractive(e.target)) return;
        const tr = e.target.closest('tr[data-href]');
        if (!tr) return;
        window.location.href = tr.dataset.href;
    });

    document.addEventListener('keydown', (e) => {
        if (e.key !== 'Enter' && e.key !== ' ') return;
        const el = document.activeElement;
        if (!el || !el.matches('tr[data-href]')) return;
        e.preventDefault();
        window.location.href = el.dataset.href;
    });
})();
</script>
@endsection
