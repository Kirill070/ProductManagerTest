@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Create product</h1>

    <form method="POST" action="{{ route('products.store') }}" class="bg-white rounded shadow-sm p-4 space-y-4">
        @csrf

        @include('products._form')

        <div class="flex items-center justify-between pt-2">
            <button type="submit"
                    class="rounded bg-slate-900 px-4 py-2 text-sm text-white">
                Save
            </button>

            <a href="{{ route('products.index') }}"
               class="text-xs text-slate-600 underline">
                Cancel
            </a>
        </div>
    </form>
@endsection
