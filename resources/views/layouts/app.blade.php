<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PIN ERP')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900">
<div class="min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-slate-700 text-slate-100 flex flex-col">
        <div class="px-6 py-5 border-b border-slate-600">
            <div class="font-bold tracking-wide">PIN</div>
            <div class="text-xs text-slate-300 mt-1 leading-4">
                Enterprise<br>Resource<br>Planning
            </div>
        </div>

        <nav class="px-3 py-4">
            <a href="{{ route('products.index') }}"
               class="block rounded px-4 py-2 text-sm {{ request()->routeIs('products.*') ? 'bg-slate-600' : 'hover:bg-slate-600/60' }}">
                Продукты
            </a>
        </nav>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col">
        <header class="h-14 bg-white border-b border-slate-200 flex items-center px-8">
            <div class="flex-1"></div>
            <div class="text-sm text-slate-500">Иванов Иван Иванович</div>
        </header>

        <main class="flex-1 p-8">
            @if(session('success'))
                <div class="mb-4 rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</div>
</body>
</html>
