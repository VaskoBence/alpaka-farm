<x-admin-layout title="Rendelések">
    <div class="admin-page-header">
        <div>
            <h1>Rendelések</h1>
            <p>
                A webshopban leadott rendelések és állapotuk kezelése.
            </p>
        </div>
    </div>

    @if (session('success'))
        <div class="admin-alert admin-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="admin-alert admin-alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="admin-list">
        @forelse ($orders as $order)
            <article class="admin-order-card">
                <div class="admin-page-header">
                    <div>
                        <h2>Rendelés #{{ $order->id }}</h2>

                        <p>
                            Leadva:
                            {{ $order->created_at->format(
                                'Y. m. d. H:i'
                            ) }}
                        </p>
                    </div>

                    <span @class([
                        'admin-status',
                        'admin-status-warning' =>
                            $order->status === 'pending',
                        'admin-status-success' =>
                            in_array(
                                $order->status,
                                ['processing', 'completed']
                            ),
                        'admin-status-danger' =>
                            $order->status === 'cancelled',
                    ])>
                        @switch($order->status)
                            @case('pending')
                                Függőben
                                @break

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
                                {{ $order->status }}
                        @endswitch
                    </span>
                </div>

                <div class="admin-grid-2">
                    <section class="admin-panel">
                        <h3>Vásárló adatai</h3>

                        <p>
                            <strong>Név:</strong>
                            {{ $order->customer_name }}
                        </p>

                        <p>
                            <strong>E-mail:</strong>

                            <a href="mailto:{{ $order->email }}">
                                {{ $order->email }}
                            </a>
                        </p>

                        <p>
                            <strong>Telefonszám:</strong>
                            {{ $order->phone }}
                        </p>

                        <p>
                            <strong>Fiók:</strong>
                            {{ $order->user
                                ? 'Regisztrált felhasználó'
                                : 'Vendég vásárlás'
                            }}
                        </p>
                    </section>

                    <section class="admin-panel">
                        <h3>Szállítás és fizetés</h3>

                        <p>
                            <strong>Szállítási cím:</strong><br>

                            {{ $order->postal_code }}
                            {{ $order->city }}<br>

                            {{ $order->address }}
                        </p>

                        <p>
                            <strong>Fizetési mód:</strong>

                            @switch($order->payment_method)
                                @case('cash_on_delivery')
                                    Utánvét
                                    @break

                                @case('bank_transfer')
                                    Banki átutalás
                                    @break

                                @default
                                    {{ $order->payment_method }}
                            @endswitch
                        </p>
                    </section>
                </div>

                <section class="admin-panel">
                    <h3>Rendelt termékek</h3>

                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Termék</th>
                                    <th>Egységár</th>
                                    <th>Mennyiség</th>
                                    <th>Részösszeg</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>
                                            {{ $item->product_name }}
                                        </td>

                                        <td>
                                            {{ number_format(
                                                $item->unit_price,
                                                0,
                                                ',',
                                                ' '
                                            ) }}
                                            Ft
                                        </td>

                                        <td>
                                            {{ $item->quantity }} db
                                        </td>

                                        <td>
                                            <strong>
                                                {{ number_format(
                                                    $item->line_total,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) }}
                                                Ft
                                            </strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <div class="admin-actions">
                    <strong>
                        Végösszeg:
                        {{ number_format(
                            $order->total_price,
                            0,
                            ',',
                            ' '
                        ) }}
                        Ft
                    </strong>

                    <form
                        class="admin-inline-form"
                        method="POST"
                        action="{{ route(
                            'admin.orders.update',
                            $order
                        ) }}"
                    >
                        @csrf
                        @method('PATCH')

                        <label for="status-{{ $order->id }}">
                            Állapot
                        </label>

                        <select
                            id="status-{{ $order->id }}"
                            name="status"
                        >
                            <option
                                value="pending"
                                @selected(
                                    $order->status === 'pending'
                                )
                            >
                                Függőben
                            </option>

                            <option
                                value="processing"
                                @selected(
                                    $order->status === 'processing'
                                )
                            >
                                Feldolgozás alatt
                            </option>

                            <option
                                value="completed"
                                @selected(
                                    $order->status === 'completed'
                                )
                            >
                                Teljesítve
                            </option>

                            <option
                                value="cancelled"
                                @selected(
                                    $order->status === 'cancelled'
                                )
                            >
                                Lemondva
                            </option>
                        </select>

                        <button
                            class="admin-button admin-button-secondary"
                            type="submit"
                        >
                            Állapot mentése
                        </button>
                    </form>
                </div>
            </article>
        @empty
            <section class="admin-panel">
                <p>Még nem érkezett rendelés.</p>
            </section>
        @endforelse
    </div>

    {{ $orders->links() }}
</x-admin-layout>