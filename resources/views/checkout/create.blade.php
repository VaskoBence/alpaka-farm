<x-public-layout title="Pénztár">
    <section class="public-section">
        <div class="public-container">
            <div class="public-section-heading">
                <p class="public-eyebrow">Webshop</p>
                <h1>Pénztár</h1>

                <p>
                    Add meg a szállításhoz és a rendelés
                    feldolgozásához szükséges adatokat.
                </p>
            </div>

            @if ($errors->any())
                <div class="public-flash public-flash-error">
                    <strong>
                        Kérjük, javítsd az alábbi hibákat:
                    </strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($items->isEmpty())
                <div class="public-content-card public-narrow">
                    <h2>A kosarad jelenleg üres</h2>

                    <p>
                        A rendelés leadásához előbb helyezz
                        legalább egy terméket a kosárba.
                    </p>

                    <a
                        class="public-button"
                        href="{{ route('products.index') }}"
                    >
                        Termékek megtekintése
                    </a>
                </div>
            @else
                <div class="public-detail-grid">
                    <div class="public-content-card">
                        <h2>Szállítási adatok</h2>

                        <form
                            class="public-form"
                            method="POST"
                            action="{{ route('checkout.store') }}"
                        >
                            @csrf

                            <div class="public-field-full">
                                <label for="customer_name">
                                    Teljes név
                                </label>

                                <input
                                    type="text"
                                    id="customer_name"
                                    name="customer_name"
                                    value="{{ old(
                                        'customer_name',
                                        auth()->user()?->name
                                    ) }}"
                                    autocomplete="name"
                                    required
                                >

                                @error('customer_name')
                                    <p class="public-field-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="email">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old(
                                        'email',
                                        auth()->user()?->email
                                    ) }}"
                                    autocomplete="email"
                                    required
                                >

                                @error('email')
                                    <p class="public-field-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone">
                                    Telefonszám
                                </label>

                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    autocomplete="tel"
                                    required
                                >

                                @error('phone')
                                    <p class="public-field-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="postal_code">
                                    Irányítószám
                                </label>

                                <input
                                    type="text"
                                    id="postal_code"
                                    name="postal_code"
                                    value="{{ old('postal_code') }}"
                                    autocomplete="postal-code"
                                    required
                                >

                                @error('postal_code')
                                    <p class="public-field-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="city">
                                    Település
                                </label>

                                <input
                                    type="text"
                                    id="city"
                                    name="city"
                                    value="{{ old('city') }}"
                                    autocomplete="address-level2"
                                    required
                                >

                                @error('city')
                                    <p class="public-field-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="public-field-full">
                                <label for="address">
                                    Utca, házszám
                                </label>

                                <input
                                    type="text"
                                    id="address"
                                    name="address"
                                    value="{{ old('address') }}"
                                    autocomplete="street-address"
                                    required
                                >

                                @error('address')
                                    <p class="public-field-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="public-field-full">
                                <label for="payment_method">
                                    Fizetési mód
                                </label>

                                <select
                                    id="payment_method"
                                    name="payment_method"
                                    required
                                >
                                    <option
                                        value="cash_on_delivery"
                                        @selected(
                                            old(
                                                'payment_method',
                                                'cash_on_delivery'
                                            ) === 'cash_on_delivery'
                                        )
                                    >
                                        Utánvét
                                    </option>

                                    <option
                                        value="bank_transfer"
                                        @selected(
                                            old('payment_method')
                                                === 'bank_transfer'
                                        )
                                    >
                                        Banki átutalás
                                    </option>
                                </select>

                                @error('payment_method')
                                    <p class="public-field-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <button
                                class="public-button"
                                type="submit"
                            >
                                Rendelés véglegesítése
                            </button>
                        </form>
                    </div>

                    <aside
                        class="public-content-card
                               public-order-summary"
                    >
                        <h2>Rendelés tartalma</h2>

                        <div class="public-stack">
                            @foreach ($items as $item)
                                <div class="public-order-line">
                                    <span>
                                        {{ $item['product']->name }}
                                        × {{ $item['quantity'] }}
                                    </span>

                                    <strong>
                                        {{ number_format(
                                            $item['subtotal'],
                                            0,
                                            ',',
                                            ' '
                                        ) }}
                                        Ft
                                    </strong>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        <div class="public-order-line">
                            <strong>Összesen</strong>

                            <strong class="public-price">
                                {{ number_format(
                                    $total,
                                    0,
                                    ',',
                                    ' '
                                ) }}
                                Ft
                            </strong>
                        </div>

                        <a
                            href="{{ route('cart.index') }}"
                            class="public-button public-button-outline"
                        >
                            Kosár módosítása
                        </a>
                    </aside>
                </div>
            @endif
        </div>
    </section>
</x-public-layout>