<x-admin-layout title="Foglalások">
    <div class="admin-page-header">
        <div>
            <h1>Foglalások</h1>
            <p>
                Beérkezett időpontfoglalások és azok állapotának kezelése.
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

    <section class="admin-panel">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Foglaló</th>
                        <th>Elérhetőség</th>
                        <th>Időpont</th>
                        <th>Létszám</th>
                        <th>Üzenet</th>
                        <th>Állapot</th>
                        <th>Művelet</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td>
                                <strong>{{ $booking->name }}</strong>

                                <small>
                                    {{ $booking->user
                                        ? 'Regisztrált felhasználó'
                                        : 'Vendég foglalás'
                                    }}
                                </small>
                            </td>

                            <td>
                                <a href="mailto:{{ $booking->email }}">
                                    {{ $booking->email }}
                                </a>

                                <small>
                                    {{ $booking->phone }}
                                </small>
                            </td>

                            <td>
                                <strong>
                                    {{ \Illuminate\Support\Carbon::parse(
                                        $booking->visit_date
                                    )->format('Y. m. d.') }}
                                </strong>

                                <small>
                                    {{ substr(
                                        (string) $booking->visit_time,
                                        0,
                                        5
                                    ) }}
                                </small>
                            </td>

                            <td>
                                {{ $booking->guests }} fő
                            </td>

                            <td>
                                {{ $booking->message ?: '—' }}
                            </td>

                            <td>
                                <span @class([
                                    'admin-status',
                                    'admin-status-warning' =>
                                        $booking->status === 'pending',
                                    'admin-status-success' =>
                                        $booking->status === 'confirmed',
                                    'admin-status-danger' =>
                                        $booking->status === 'cancelled',
                                ])>
                                    @switch($booking->status)
                                        @case('pending')
                                            Függőben
                                            @break

                                        @case('confirmed')
                                            Visszaigazolva
                                            @break

                                        @case('cancelled')
                                            Lemondva
                                            @break

                                        @default
                                            {{ $booking->status }}
                                    @endswitch
                                </span>
                            </td>

                            <td>
                                <form
                                    class="admin-inline-form"
                                    method="POST"
                                    action="{{ route(
                                        'admin.bookings.update',
                                        $booking
                                    ) }}"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <select
                                        name="status"
                                        aria-label="Foglalás állapota"
                                    >
                                        <option
                                            value="pending"
                                            @selected(
                                                $booking->status === 'pending'
                                            )
                                        >
                                            Függőben
                                        </option>

                                        <option
                                            value="confirmed"
                                            @selected(
                                                $booking->status ===
                                                'confirmed'
                                            )
                                        >
                                            Visszaigazolva
                                        </option>

                                        <option
                                            value="cancelled"
                                            @selected(
                                                $booking->status ===
                                                'cancelled'
                                            )
                                        >
                                            Lemondva
                                        </option>
                                    </select>

                                    <button
                                        class="admin-button admin-button-secondary"
                                        type="submit"
                                    >
                                        Mentés
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                Még nem érkezett időpontfoglalás.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $bookings->links() }}
    </section>
</x-admin-layout>