@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Edit product</h1>

    <form method="POST"
          action="{{ route('products.update', $product) }}"
          class="bg-white rounded shadow-sm p-4 space-y-4">

        @csrf
        @method('PUT')

        @include('products._form', ['product' => $product])

        <div class="flex items-center justify-between pt-2">
            <button type="submit"
                    class="rounded bg-slate-900 px-4 py-2 text-sm text-white">
                Update
            </button>

            <a href="{{ route('products.show', $product) }}"
               class="text-xs text-slate-600 underline">
                Cancel
            </a>
        </div>
    </form>
@endsection
