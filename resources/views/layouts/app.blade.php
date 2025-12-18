<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'ProductManagerTest' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white">
<div class="min-h-screen flex">

    <aside class="w-[181px] bg-[#374050] text-white">
        <div class="h-[59px]"></div>

        <nav class="px-8 pt-3">
            <a href="{{ route('products.index') }}"
            class="block text-[12px] leading-[11px] text-white/70">
                Продукты
            </a>
        </nav>
    </aside>

    <div class="flex-1">
        <header class="h-[59px] bg-white flex items-center justify-between">
            <div class="pl-[18px] text-[11px] leading-[11px] text-[#ED1C24] uppercase">
                ПРОДУКТЫ
            </div>

            <div class="pr-[31px] text-[11px] leading-[11px] text-[#A6AFB8]">
                Иванов Иван Иванович
            </div>
        </header>

        <div class="ml-[18px] h-[3px] w-[60px] bg-[#ED1C24]"></div>

        <main class="bg-[#F2F6FA] min-h-[calc(100vh-62px)]">
            @yield('content')
        </main>
    </div>

</div>
</body>
</html>
