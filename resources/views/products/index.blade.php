@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Products</h1>
        <a href="{{ route('products.create') }}"
           class="rounded bg-slate-900 px-4 py-2 text-sm text-white">
            + New product
        </a>
    </div>

    @if($products->isEmpty())
        <p class="text-sm text-slate-500">No products yet.</p>
    @else
        <div class="bg-white rounded shadow-sm overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Article</th>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $product->id }}</td>
                        <td class="px-4 py-2">{{ $product->article }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('products.show', $product) }}"
                               class="text-sky-700 hover:underline">
                                {{ $product->name }}
                            </a>
                        </td>
                        <td class="px-4 py-2">
                            <span class="inline-flex rounded-full px-2 py-0.5 text-xs
                                {{ $product->status === 'available'
                                    ? 'bg-emerald-50 text-emerald-700'
                                    : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('products.edit', $product) }}"
                               class="text-xs text-sky-700 hover:underline">
                                Edit
                            </a>

                            <form action="{{ route('products.destroy', $product) }}"
                                  method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-xs text-rose-700 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
@endsection
