@props(['title' => 'Alpaka farm'])

@php
    $cartCount = array_sum(session('cart', []));

    $navigationLinks = [
        [
            'label' => 'Főoldal',
            'route' => 'home',
            'pattern' => 'home',
        ],
        [
            'label' => 'Farmunk',
            'route' => 'about',
            'pattern' => 'about',
        ],
        [
            'label' => 'Időpontfoglalás',
            'route' => 'bookings.create',
            'pattern' => 'bookings.*',
        ],
        [
            'label' => 'Webshop',
            'route' => 'products.index',
            'pattern' => 'products.*',
        ],
        [
            'label' => 'Kapcsolat',
            'route' => 'contact',
            'pattern' => 'contact',
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $title }} | Alpaka farm</title>

    <link
        rel="icon"
        href="{{ asset('favicon.ico') }}?v=5"
        sizes="any"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="public-site">
    <header class="public-header">
        <div class="public-container public-navigation">
            <a
                class="public-brand"
                href="{{ route('home') }}"
            >
                <img
                    class="public-brand-logo"
                    src="{{ asset('images/alpaka-logo.png') }}"
                    alt=""
                    aria-hidden="true"
                >

                <span>Alpaka Farm</span>
            </a>

            <input
                class="public-menu-checkbox"
                type="checkbox"
                id="public-menu-toggle"
                aria-label="Menü megnyitása"
            >

            <label
                class="public-menu-toggle"
                for="public-menu-toggle"
                aria-hidden="true"
            >
                <span></span>
                <span></span>
                <span></span>
            </label>

            <div class="public-menu-content">
                <nav
                    class="public-nav-links"
                    aria-label="Fő navigáció"
                >
                    @foreach ($navigationLinks as $link)
                        @php
                            $isActive = request()
                                ->routeIs($link['pattern']);
                        @endphp

                        <a
                            class="{{ $isActive ? 'active' : '' }}"
                            href="{{ route($link['route']) }}"
                            @if ($isActive) aria-current="page" @endif
                        >
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="public-account-links">
                    <a href="{{ route('cart.index') }}">
                        Kosár

                        @if ($cartCount > 0)
                            <span class="public-cart-count">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    @auth
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}">
                                Admin
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}">
                                Profilom
                            </a>
                        @endif

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <button
                                class="public-logout"
                                type="submit"
                            >
                                Kilépés
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">
                            Belépés
                        </a>

                        <a href="{{ route('register') }}">
                            Regisztráció
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="public-footer">
        <div class="public-container public-footer-grid">
            <div>
                <strong>Alpaka Farm</strong>

                <p>
                    Családi alpakafarm, élményprogramokkal
                    és kézzel készült termékekkel.
                </p>
            </div>

            <div class="public-footer-contact">
                <strong>Kapcsolat</strong>

                <p>
                    <a href="mailto:hello@alpakafarm.example">
                        hello@alpakafarm.example
                    </a>
                    <br>

                    +36 00 000 0000
                </p>
            </div>
        </div>

        <div class="public-container public-footer-bottom">
            <small>
                © {{ now()->year }} Alpaka Farm
            </small>
        </div>
    </footer>
</body>
</html>