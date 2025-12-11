<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Product Manager Test' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900">
    <div class="min-h-screen">
        <header class="bg-white shadow">
            <div class="max-w-5xl mx-auto px-4 py-4 flex justify-between items-center">
                <a href="{{ route('products.index') }}" class="font-semibold text-lg">
                    ProductManagerTest
                </a>

                <nav class="space-x-4 text-sm">
                    <a href="{{ route('products.index') }}">Products</a>
                    <a href="{{ route('products.create') }}">Create</a>
                </nav>
            </div>
        </header>

        <main class="max-w-5xl mx-auto px-4 py-6">
            @if (session('success'))
                <div class="mb-4 rounded border border-emerald-300 bg-emerald-50 px-4 py-2 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded border border-rose-300 bg-rose-50 px-4 py-2 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
