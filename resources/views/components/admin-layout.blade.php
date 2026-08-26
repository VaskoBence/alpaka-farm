@props(['title' => 'Admin'])

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $title }} | Alpaka Farm Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-site">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a
                class="admin-brand"
                href="{{ route('admin.dashboard') }}"
            >
                Alpaka Farm

                <small>Adminisztráció</small>
            </a>

            <nav class="admin-nav">
                <a
                    class="admin-nav-link
                        {{ request()->routeIs('admin.dashboard')
                            ? 'active'
                            : '' }}"
                    href="{{ route('admin.dashboard') }}"
                >
                    Vezérlőpult
                </a>

                <a
                    class="admin-nav-link
                        {{ request()->routeIs('admin.products.*')
                            ? 'active'
                            : '' }}"
                    href="{{ route('admin.products.index') }}"
                >
                    Termékek
                </a>

                <a
                    class="admin-nav-link
                        {{ request()->routeIs('admin.bookings.*')
                            ? 'active'
                            : '' }}"
                    href="{{ route('admin.bookings.index') }}"
                >
                    Foglalások
                </a>

                <a
                    class="admin-nav-link
                        {{ request()->routeIs('admin.orders.*')
                            ? 'active'
                            : '' }}"
                    href="{{ route('admin.orders.index') }}"
                >
                    Rendelések
                </a>
            </nav>

            <div class="admin-sidebar-footer">
                <div>
                    <p>{{ auth()->user()->name }}</p>
                    <small>{{ auth()->user()->email }}</small>
                </div>

                <a
                    class="admin-nav-link"
                    href="{{ route('home') }}"
                    target="_blank"
                    rel="noopener"
                >
                    Weboldal megnyitása
                </a>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        class="admin-logout"
                        type="submit"
                    >
                        Kijelentkezés
                    </button>
                </form>
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <h1>{{ $title }}</h1>

                <a href="{{ route('home') }}">
                    Nyilvános oldal
                </a>
            </header>

            <main class="admin-content">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>