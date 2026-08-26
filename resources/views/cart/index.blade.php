<x-public-layout title="Kosár">
    <section class="public-section">
        <div class="public-container">
            <div class="public-section-heading">
                <p class="public-eyebrow">Webshop</p>
                <h1>Kosár</h1>

                <p>
                    Ellenőrizd a kiválasztott termékeket,
                    mielőtt továbblépsz a pénztárhoz.
                </p>
            </div>

            @if (session('success'))
                <p class="public-flash public-flash-success">
                    {{ session('success') }}
                </p>
            @endif

            @error('cart')
                <p class="public-flash public-flash-error">
                    {{ $message }}
                </p>
            @enderror

            @error('quantity')
                <p class="public-flash public-flash-error">
                    {{ $message }}
                </p>
            @enderror

            <div class="public-stack">
                @forelse ($items as $item)
                    @php
                        $product = $item['product'];
                    @endphp

                    <article class="public-cart-item">
                        <div class="public-cart-media">
                            @if ($product->image_path)
                                <img
                                    src="{{ asset(
                                        'storage/'
                                        . $product->image_path
                                    ) }}"
                                    alt="{{ $product->name }}"
                                >
                            @else
                                <div
                                    class="public-cart-placeholder"
                                >
                                    Nincs kép
                                </div>
                            @endif
                        </div>

                        <div>
                            <h2>{{ $product->name }}</h2>

                            <p>
                                Egységár:

                                <strong>
                                    {{ number_format(
                                        $product->price,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                    Ft
                                </strong>
                            </p>

                            <p>
                                Részösszeg:

                                <strong class="public-price">
                                    {{ number_format(
                                        $item['subtotal'],
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                    Ft
                                </strong>
                            </p>

                            @if (! $product->is_active)
                                <p
                                    class="
                                        public-stock
                                        public-stock-empty
                                    "
                                >
                                    Ez a termék már nem
                                    rendelhető. Távolítsd el
                                    a kosárból.
                                </p>
                            @elseif (
                                $product->stock
                                    < $item['quantity']
                            )
                                <p
                                    class="
                                        public-stock
                                        public-stock-empty
                                    "
                                >
                                    Már csak
                                    {{ $product->stock }} db van
                                    készleten. Csökkentsd
                                    a mennyiséget.
                                </p>
                            @endif

                            <div
                                class="public-cart-controls"
                            >
                                @if (
                                    $product->is_active
                                    && $product->stock > 0
                                )
                                    <form
                                        class="
                                            public-cart-controls
                                        "
                                        method="POST"
                                        action="{{ route(
                                            'cart.update',
                                            $product
                                        ) }}"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <label
                                            class="sr-only"
                                            for="quantity-{{ $product->id }}"
                                        >
                                            Mennyiség
                                        </label>

                                        <input
                                            class="
                                                public-quantity-input
                                            "
                                            type="number"
                                            id="quantity-{{ $product->id }}"
                                            name="quantity"
                                            min="1"
                                            max="{{ $product->stock }}"
                                            value="{{ min(
                                                $item['quantity'],
                                                $product->stock
                                            ) }}"
                                        >

                                        <button
                                            class="
                                                public-button
                                                public-button-outline
                                            "
                                            type="submit"
                                        >
                                            Frissítés
                                        </button>
                                    </form>
                                @endif

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'cart.destroy',
                                        $product
                                    ) }}"
                                    onsubmit="
                                        return confirm(
                                            'Biztosan eltávolítod ezt a terméket?'
                                        )
                                    "
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="
                                            public-button
                                            public-button-danger
                                        "
                                        type="submit"
                                    >
                                        Eltávolítás
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="public-content-card">
                        <h2>
                            A kosarad jelenleg üres
                        </h2>

                        <p>
                            Nézd meg az alpaka témájú
                            termékeinket, és válaszd ki
                            a kedvenceidet.
                        </p>

                        <a
                            class="public-button"
                            href="{{ route(
                                'products.index'
                            ) }}"
                        >
                            Termékek megtekintése
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($items->isNotEmpty())
                <div
                    class="public-content-card"
                    style="margin-top: 2rem;"
                >
                    <h2>
                        Összesen:

                        <span class="public-price">
                            {{ number_format(
                                $total,
                                0,
                                ',',
                                ' '
                            ) }}
                            Ft
                        </span>
                    </h2>

                    <div class="public-actions">
                        @if ($canCheckout)
                            <a
                                class="public-button"
                                href="{{ route(
                                    'checkout.create'
                                ) }}"
                            >
                                Tovább a pénztárhoz
                            </a>
                        @else
                            <p
                                class="
                                    public-flash
                                    public-flash-error
                                "
                            >
                                A továbblépés előtt javítsd
                                vagy távolítsd el a már nem
                                rendelhető kosártételeket.
                            </p>
                        @endif

                        <a
                            class="
                                public-button
                                public-button-outline
                            "
                            href="{{ route(
                                'products.index'
                            ) }}"
                        >
                            Vásárlás folytatása
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-public-layout>