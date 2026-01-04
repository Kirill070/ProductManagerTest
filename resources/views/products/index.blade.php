@extends('layouts.app')

@section('title', 'Продукты')

@php
    $panel = $panel ?? null;

    $statusLabel = fn($status) => $status === 'available' ? 'Доступен' : 'Не доступен';

    // Для формы: старые значения (при ошибках) важнее, чем данные из модели
    $form = [
        'article' => old('article', $product->article ?? ''),
        'name' => old('name', $product->name ?? ''),
        'status' => old('status', $product->status ?? 'available'),
    ];

    // data в форме — список строк key/value
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
<div class="flex gap-8 items-start">

    {{-- Left: list --}}
    <section class="flex-1 min-w-0">
        <div class="flex items-end justify-between mb-4">
            <div>
                <h1 class="text-sm font-semibold tracking-widest text-red-600 uppercase">Продукты</h1>
                <div class="h-0.5 w-20 bg-red-600 mt-2"></div>
            </div>

            <a href="{{ route('products.create') }}"
               class="inline-flex items-center rounded bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                Добавить
            </a>
        </div>

        <div class="bg-white border border-slate-200 rounded">
            <table class="min-w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                <tr class="text-left text-xs uppercase tracking-wider text-slate-400">
                    <th class="px-5 py-3 w-40">Артикул</th>
                    <th class="px-5 py-3">Название</th>
                    <th class="px-5 py-3 w-40">Статус</th>
                    <th class="px-5 py-3 w-72">Атрибуты</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                @forelse($products as $p)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4 text-sm text-slate-600">
                            <a class="hover:underline" href="{{ route('products.show', $p) }}">{{ $p->article }}</a>
                        </td>
                        <td class="px-5 py-4 text-sm">
                            <a class="hover:underline" href="{{ route('products.show', $p) }}">{{ $p->name }}</a>
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-600">
                            {{ $statusLabel($p->status) }}
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-600">
                            @if(is_array($p->data) && count($p->data))
                                @foreach($p->data as $k => $v)
                                    <div>{{ $k }}: {{ $v }}</div>
                                @endforeach
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-16 text-center text-slate-400">
                            Список продуктов пуст
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="px-5 py-4 border-t border-slate-200">
                {{ $products->links() }}
            </div>
        </div>
    </section>

    {{-- Right: panel --}}
    @if($panel)
        <aside class="w-[560px] bg-slate-700 text-slate-100 rounded shadow-lg overflow-hidden">
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
        </aside>
    @endif

</div>
@endsection
