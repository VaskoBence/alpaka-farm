<x-admin-layout title="Vezérlőpult">
    <div class="admin-page-header">
        <div>
            <h2>Áttekintés</h2>
            <p>Az Alpaka Farm aktuális adatai.</p>
        </div>
    </div>

    <div class="admin-stats">
        <a
            class="admin-stat-card"
            href="{{ route('admin.products.index') }}"
        >
            <span>Termékek</span>
            <strong>{{ $productCount }}</strong>
        </a>

        <a
            class="admin-stat-card"
            href="{{ route('admin.bookings.index') }}"
        >
            <span>Függő foglalások</span>
            <strong>{{ $pendingBookingCount }}</strong>
        </a>

        <a
            class="admin-stat-card"
            href="{{ route('admin.orders.index') }}"
        >
            <span>Függő rendelések</span>
            <strong>{{ $pendingOrderCount }}</strong>
        </a>
    </div>

    <div class="admin-grid-2">
        <section class="admin-panel">
            <h3>Legutóbbi rendelések</h3>

            <div class="admin-list">
                @forelse ($latestOrders as $order)
                    <div class="admin-list-item">
                        <strong>
                            #{{ $order->id }} –
                            {{ $order->customer_name }}
                        </strong>

                        <p>
                            {{ number_format(
                                $order->total_price,
                                0,
                                ',',
                                ' '
                            ) }}
                            Ft
                        </p>

                        <p>
                            {{ $order->created_at->format(
                                'Y.m.d. H:i'
                            ) }}
                        </p>
                    </div>
                @empty
                    <p>Még nincs rendelés.</p>
                @endforelse
            </div>
        </section>

        <section class="admin-panel">
            <h3>Közelgő foglalások</h3>

            <div class="admin-list">
                @forelse ($upcomingBookings as $booking)
                    <div class="admin-list-item">
                        <strong>{{ $booking->name }}</strong>

                        <p>
                            {{ $booking->visit_date->format(
                                'Y.m.d.'
                            ) }}
                            –
                            {{ substr(
                                $booking->visit_time,
                                0,
                                5
                            ) }}
                        </p>

                        <p>{{ $booking->guests }} fő</p>
                    </div>
                @empty
                    <p>Nincs közelgő foglalás.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-admin-layout>