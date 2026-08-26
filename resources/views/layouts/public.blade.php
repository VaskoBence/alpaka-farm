<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Alpaka')</title>
    <meta name="description" content="@yield('description','Alpakafarm-látogatás, időpontfoglalás, termékvásárlás')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-[#f7f2e8] text-[#25352d] antialiased">
    <header class="sticky top-0 z-50 border-b border-[#25352d]/10 bg-[#f7f2e8]/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#245c43] text-sm font-bold text-white">
                    AL
                </span>

                <span>
                    <span class="block text-lg font-semibold leading-none">Alpaka Liget</span>
                    <span class="text-xs text-[#5e6d65]">Élményfarm és webshop</span>
                </span>
            </a>

            <nav class="hidden items-center gap-7 text-sm font-medium md:flex">
                <a href="#alpakak" class="transition hover:text-[#c66f3d]">Alpakáink</a>
                <a href="#latogatas" class="transition hover:text-[#c66f3d]">Farmlátogatás</a>
                <a href="#webshop" class="transition hover:text-[#c66f3d]">Webshop</a>

                @auth
                    <a
                        href="{{ route('dashboard') }}"
                        class="rounded-full bg-[#245c43] px-5 py-2.5 text-white transition hover:bg-[#194832]"
                    >
                        Fiókom
                    </a>
                @else
                    <a href="{{ route('login') }}" class="transition hover:text-[#c66f3d]">
                        Belépés
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="rounded-full bg-[#245c43] px-5 py-2.5 text-white transition hover:bg-[#194832]"
                    >
                        Regisztráció
                    </a>
                @endauth
            </nav>

            <details class="relative md:hidden">
                <summary class="cursor-pointer list-none rounded-lg border border-[#25352d]/20 px-3 py-2 text-sm">
                    Menü
                </summary>

                <nav class="absolute right-0 mt-3 flex w-56 flex-col gap-3 rounded-2xl bg-white p-5 shadow-xl">
                    <a href="#alpakak">Alpakáink</a>
                    <a href="#latogatas">Farmlátogatás</a>
                    <a href="#webshop">Webshop</a>

                    @auth
                        <a href="{{ route('dashboard') }}">Fiókom</a>
                    @else
                        <a href="{{ route('login') }}">Belépés</a>
                        <a href="{{ route('register') }}">Regisztráció</a>
                    @endauth
                </nav>
            </details>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t border-[#25352d]/10 bg-[#e9e1d3]">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 px-5 py-8 text-sm text-[#5e6d65] md:flex-row md:items-center md:justify-between lg:px-8">
            <p>© {{ date('Y') }} Alpaka Liget</p>

            <div class="flex gap-5">
                <a href="#" class="hover:text-[#25352d]">Kapcsolat</a>
                <a href="#" class="hover:text-[#25352d]">Adatkezelés</a>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>