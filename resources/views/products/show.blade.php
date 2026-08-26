<x-public-layout :title="$product->name">
    <section class="public-section">
        <div class="public-container">
            <div style="margin-bottom: 1.5rem;">
                <a
                    href="{{ route('products.index') }}"
                    class="public-back-link"
                >
                    ← Vissza a termékekhez
                </a>
            </div>

            <article class="public-detail-grid">
                <div>
                    @if ($product->image_path)
                        <img
                            class="public-detail-image"
                            src="{{ asset(
                                'storage/' . $product->image_path
                            ) }}"
                            alt="{{ $product->name }}"
                        >
                    @else
                        <div
                            class="public-product-placeholder
                                   public-detail-placeholder"
                        >
                            Nincs kép
                        </div>
                    @endif
                </div>

                <div class="public-content-card">
                    <p class="public-eyebrow">
                        Alpakafarm webshop
                    </p>

                    <h1>{{ $product->name }}</h1>

                    <p class="public-product-long-description">
                        {{ $product->description
                            ?: 'Ehhez a termékhez még nincs leírás.' }}
                    </p>

                    <p class="public-price public-detail-price">
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

                        <form
                            class="public-purchase-form"
                            method="POST"
                            action="{{ route(
                                'cart.store',
                                $product
                            ) }}"
                        >
                            @csrf

                            <div>
                                <label
                                    for="quantity"
                                    class="public-quantity-label"
                                >
                                    Mennyiség
                                </label>

                                <input
                                    class="public-quantity-input"
                                    type="number"
                                    id="quantity"
                                    name="quantity"
                                    min="1"
                                    max="{{ $product->stock }}"
                                    value="{{ old('quantity', 1) }}"
                                >
                            </div>

                            <button
                                class="public-button"
                                type="submit"
                            >
                                Kosárba teszem
                            </button>
                        </form>

                        @error('quantity')
                            <p class="public-field-error">
                                {{ $message }}
                            </p>
                        @enderror
                    @else
                        <p class="public-flash public-flash-error">
                            Ez a termék jelenleg nincs készleten.
                        </p>
                    @endif

                    <a
                        class="public-button public-button-outline"
                        href="{{ route('cart.index') }}"
                    >
                        Kosár megnyitása
                    </a>
                </div>
            </article>
        </div>
    </section>
</x-public-layout>