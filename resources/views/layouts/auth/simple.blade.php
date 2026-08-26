<!DOCTYPE html>
<html lang="hu">
    <head>
        @include('partials.head')
    </head>

    <body class="auth-body">
        <div class="auth-page">
            <header class="auth-topbar">
                <a
                    class="auth-brand"
                    href="{{ route('home') }}"
                >
                    <span class="auth-brand-mark">
                        AF
                    </span>

                    <span class="auth-brand-text">
                        <strong>Alpaka Farm</strong>
                        <span>Élmények és kézműves termékek</span>
                    </span>
                </a>
            </header>

            <main class="auth-main">
                <div class="auth-shell">
                    <section class="auth-intro">
                        <div class="auth-intro-content">
                            <p class="auth-kicker">
                                Alpaka Farm
                            </p>

                            <h1>
                                Egy nyugodtabb hely, közelebb a természethez.
                            </h1>

                            <p class="auth-intro-description">
                                Fiókoddal egy helyen követheted a rendeléseidet
                                és a lefoglalt időpontjaidat.
                            </p>

                            <div class="auth-features">
                                <span class="auth-feature">
                                    Saját rendelések
                                </span>

                                <span class="auth-feature">
                                    Időpontfoglalások
                                </span>

                                <span class="auth-feature">
                                    Alpaka termékek
                                </span>
                            </div>
                        </div>
                    </section>

                    <section class="auth-form-panel">
                        {{ $slot }}
                    </section>
                </div>
            </main>

            <footer class="auth-page-footer">
                © {{ date('Y') }} Alpaka Farm
            </footer>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>