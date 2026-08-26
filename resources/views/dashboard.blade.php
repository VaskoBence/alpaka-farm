<x-public-layout title="Saját profil">
    <section class="public-section">
        <div class="public-container">
            <div class="public-section-heading">
                <p class="public-eyebrow">Saját fiók</p>

                <h1>Üdv, {{ auth()->user()->name }}!</h1>

                <p>
                    Itt követheted a fiókoddal leadott
                    rendeléseidet és időpontfoglalásaidat.
                </p>
            </div>

            <div class="public-profile-summary">
                <div class="public-card">
                    <h2>Fiókadatok</h2>

                    <p>
                        <strong>Név:</strong>
                        {{ auth()->user()->name }}
                    </p>

                    <p>
                        <strong>Email:</strong>
                        {{ auth()->user()->email }}
                    </p>

                    <a
                        class="public-button public-button-outline"
                        href="{{ url('/settings/profile') }}"
                    >
                        Profil szerkesztése
                    </a>
                </div>

                <div class="public-card">
                    <h2>Összesítés</h2>

                    <p>
                        <strong>{{ $orders->count() }}</strong>
                        fiókhoz kapcsolt rendelés
                    </p>

                    <p>
                        <strong>{{ $bookings->count() }}</strong>
                        fiókhoz kapcsolt időpontfoglalás
                    </p>
                </div>
            </div>

            <section class="public-dashboard-section">
                <div class="public-section-heading">
                    <h2>Rendeléseim</h2>
                </div>

                <div class="public-stack">
                    @forelse ($orders as $order)
                        <article class="public-content-card">
                            <div class="public-history-header">
                                <div>
                                    <h3>
                                        Rendelés #{{ $order->id }}
                                    </h3>

                                    <p>
                                        {{ $order->created_at->format(
                                            'Y.m.d. H:i'
                                        ) }}
                                    </p>
                                </div>

                                <span class="public-status">
                                    @switch($order->status)
                                        @case('processing')
                                            Feldolgozás alatt
                                            @break

                                        @case('completed')
                                            Teljesítve
                                            @break

                                        @case('cancelled')
                                            Lemondva
                                            @break

                                        @default
                                            Függőben
                                    @endswitch
                                </span>
                            </div>

                            <details>
                                <summary>
                                    Rendelés részletei
                                </summary>

                                <ul>
                                    @foreach ($order->items as $item)
                                        <li>
                                            {{ $item->product_name }}
                                            × {{ $item->quantity }}
                                            –
                                            {{ number_format(
                                                $item->line_total,
                                                0,
                                                ',',
                                                ' '
                                            ) }}
                                            Ft
                                        </li>
                                    @endforeach
                                </ul>
                            </details>

                            <p class="public-price">
                                Összesen:
                                {{ number_format(
                                    $order->total_price,
                                    0,
                                    ',',
                                    ' '
                                ) }}
                                Ft
                            </p>
                        </article>
                    @empty
                        <div class="public-content-card">
                            <p>
                                A fiókodhoz még nem tartozik
                                rendelés.
                            </p>

                            <a
                                class="public-button"
                                href="{{ route('products.index') }}"
                            >
                                Webshop megnyitása
                            </a>
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="public-dashboard-section">
                <div class="public-section-heading">
                    <h2>Időpontfoglalásaim</h2>
                </div>

                <div class="public-stack">
                    @forelse ($bookings as $booking)
                        <article class="public-content-card">
                            <div class="public-history-header">
                                <div>
                                    <h3>
                                        {{ $booking->visit_date->format(
                                            'Y.m.d.'
                                        ) }}
                                        –
                                        {{ substr(
                                            $booking->visit_time,
                                            0,
                                            5
                                        ) }}
                                    </h3>

                                    <p>
                                        {{ $booking->guests }} fő
                                    </p>
                                </div>

                                <span class="public-status">
                                    @switch($booking->status)
                                        @case('confirmed')
                                            Elfogadva
                                            @break

                                        @case('cancelled')
                                            Elutasítva
                                            @break

                                        @default
                                            Függőben
                                    @endswitch
                                </span>
                            </div>

                            @if ($booking->message)
                                <p>
                                    <strong>Megjegyzés:</strong>
                                    {{ $booking->message }}
                                </p>
                            @endif
                        </article>
                    @empty
                        <div class="public-content-card">
                            <p>
                                A fiókodhoz még nem tartozik
                                időpontfoglalás.
                            </p>

                            <a
                                class="public-button"
                                href="{{ route('bookings.create') }}"
                            >
                                Időpontfoglalás
                            </a>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </section>
</x-public-layout>