<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Менеджер продуктов')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F2F6F9] text-[#363F50]">
<div class="min-h-screen flex">

    <aside class="w-[181px] bg-[#363F50] text-white flex flex-col">
        <div class="flex h-[96px]">
            <div class="w-[79px] h-[59px] bg-white flex items-center justify-center rounded-br-[20px] overflow-hidden">
                <img
                    src="{{ asset('img/pin-logo.svg') }}"
                    alt="PIN"
                    class="w-[58px] h-auto"
                >
            </div>
            <div class="flex-1 px-4 py-4 leading-tight">
                <div class="text-[10px] text-white/90">
                    Enterprise<br>Resource<br>Planning
                </div>
            </div>
        </div>

        <nav class="pt-2">
            <a href="{{ route('products.index') }}"
               class="block px-10 py-1 text-[12px] {{ request()->routeIs('products.*') }}">
                Продукты
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="bg-white h-[64px] border-b border-[#E6EBF0]">
            <div class="h-full flex items-start justify-between px-[56px] pt-[25px]">
                <div class="leading-none">
                    <div class="text-[11px] font-semibold tracking-widest text-[#E31B23] uppercase">Продукты</div>
                    <div class="mt-4 h-0.5 w-24 bg-[#E31B23]"></div>
                </div>
                <div class="text-[11px] text-[#A0A8B3]">Иванов Иван Иванович</div>
            </div>
        </header>

        <main class="flex-1 bg-[#F2F6F9]">
            @if(session('success'))
                <div class="mx-[56px] mt-4 inline-block rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</div>
</body>
</html>
