<x-public-layout title="Sikeres rendelés">
    <section class="public-section">
        <div class="public-container public-narrow">
            <div
                class="
                    public-content-card
                    public-success-card
                "
            >
                <div
                    class="public-success-icon"
                    aria-hidden="true"
                >
                    ✓
                </div>

                <p class="public-eyebrow">
                    Sikeres rendelés
                </p>

                <h1>Köszönjük a rendelést!</h1>

                <p>
                    A rendelésedet rögzítettük,
                    és hamarosan megkezdjük
                    a feldolgozását.
                </p>

                @if (session('order_id'))
                    <p class="public-order-number">
                        Rendelési azonosító:

                        <strong>
                            #{{ session('order_id') }}
                        </strong>
                    </p>
                @endif

                <p>
                    A rendelés feldolgozásakor
                    a megadott elérhetőségeid egyikén
                    keresünk.
                </p>

                <div class="public-actions">
                    <a
                        class="public-button"
                        href="{{ route(
                            'products.index'
                        ) }}"
                    >
                        Vissza a webshophoz
                    </a>

                    <a
                        class="
                            public-button
                            public-button-outline
                        "
                        href="{{ route('home') }}"
                    >
                        Főoldal
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>