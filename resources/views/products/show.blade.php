@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-xl font-semibold">{{ $product->name }}</h1>
            <p class="text-xs text-slate-500">
                Article: {{ $product->article }} · ID: {{ $product->id }}
            </p>
        </div>

        <div class="space-x-2">
            <a href="{{ route('products.edit', $product) }}"
               class="rounded bg-slate-900 px-3 py-2 text-xs text-white">
                Edit
            </a>
            <a href="{{ route('products.index') }}"
               class="text-xs text-slate-600 underline">
                Back to list
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 bg-white rounded shadow-sm p-4 text-sm space-y-3">
            <div>
                <div class="text-xs text-slate-500 mb-1">Status</div>
                <span class="inline-flex rounded-full px-2 py-0.5 text-xs
                    {{ $product->status === 'available'
                        ? 'bg-emerald-50 text-emerald-700'
                        : 'bg-slate-100 text-slate-600' }}">
                    {{ ucfirst($product->status) }}
                </span>
            </div>

            <div>
                <div class="text-xs text-slate-500 mb-1">Color</div>
                <div>{{ $product->data['color'] ?? '—' }}</div>
            </div>

            <div>
                <div class="text-xs text-slate-500 mb-1">Size</div>
                <div>{{ $product->data['size'] ?? '—' }}</div>
            </div>

            <div>
                <div class="text-xs text-slate-500 mb-1">Raw data</div>
                <pre class="text-xs bg-slate-50 rounded p-2 overflow-x-auto">
{{ json_encode($product->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                </pre>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm p-4 text-xs text-slate-600 space-y-1">
            <div>Created at: {{ $product->created_at }}</div>
            <div>Updated at: {{ $product->updated_at }}</div>
            @if($product->deleted_at)
                <div>Deleted at: {{ $product->deleted_at }}</div>
            @endif
        </div>
    </div>
@endsection
