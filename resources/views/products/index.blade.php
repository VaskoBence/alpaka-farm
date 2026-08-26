<x-public-layout title="Webshop">
    <section
        class="public-section public-page-background"
        style="--public-page-image: url('{{ asset('images/webshop-background.png') }}');"
    >
        <div class="public-container">
            <div class="public-section-heading">
                <p class="public-eyebrow">Alpakafarm webshop</p>

                <h1>Termékeink</h1>

                <p>
                    Alpaka témájú ajándékok és gondosan
                    kiválasztott, kézzel készült termékek.
                </p>
            </div>

            <div class="public-product-grid">
                @forelse ($products as $product)
                    <article class="public-product-card">
                        @if ($product->image_path)
                            <a
                                href="{{ route(
                                    'products.show',
                                    $product
                                ) }}"
                            >
                                <img
                                    class="public-product-image"
                                    src="{{ asset(
                                        'storage/'
                                        . $product->image_path
                                    ) }}"
                                    alt="{{ $product->name }}"
                                >
                            </a>
                        @else
                            <div class="public-product-placeholder">
                                Nincs kép
                            </div>
                        @endif

                        <h2>
                            <a href="{{ route(
                                'products.show',
                                $product
                            ) }}">
                                {{ $product->name }}
                            </a>
                        </h2>

                        <p class="public-product-description">
                            {{ \Illuminate\Support\Str::limit(
                                $product->description
                                    ?? 'Ehhez a termékhez még nincs leírás.',
                                120
                            ) }}
                        </p>

                        <p class="public-price">
                            {{ number_format(
                                $product->price,
                                0,
                                ',',
                                ' '
                            ) }}
                            Ft
                        </p>

                        @if ($product->stock > 0)
                            <p class="public-stock public-stock-available">
                                Készleten: {{ $product->stock }} db
                            </p>
                        @else
                            <p class="public-stock public-stock-empty">
                                Jelenleg nincs készleten
                            </p>
                        @endif

                        <a
                            class="public-button"
                            href="{{ route(
                                'products.show',
                                $product
                            ) }}"
                        >
                            Termék megtekintése
                        </a>
                    </article>
                @empty
                    <div class="public-content-card">
                        <h2>Jelenleg nincs elérhető termék</h2>

                        <p>
                            Nézz vissza később az új alpaka
                            témájú termékekért.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-public-layout>