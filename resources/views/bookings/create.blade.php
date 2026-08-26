<x-public-layout title="Időpontfoglalás">
    <section
        class="public-section public-page-background"
        style="--public-page-image: url('{{ asset('images/idopont-background.png') }}');"
    >
        <div class="public-container">
            <div class="public-section-heading">
                <p class="public-eyebrow">Alpakaélmény</p>

                <h1>Időpontfoglalás</h1>

                <p>
                    Válassz megfelelő időpontot, és küldd el
                    foglalási igényedet. A foglalást minden
                    esetben visszaigazoljuk.
                </p>
            </div>

            @if (session('success'))
                <p class="public-flash public-flash-success">
                    {{ session('success') }}
                </p>
            @endif

            <div class="public-detail-grid">
                <aside class="public-content-card">
                    <h2>Fontos tudnivalók</h2>

                    <ul>
                        <li>
                            Egy látogatás körülbelül
                            60–90 percig tart.
                        </li>

                        <li>
                            Egy alkalomra legfeljebb
                            10 fő jelentkezhet.
                        </li>

                        <li>
                            Gyerekek csak felnőtt kíséretével
                            vehetnek részt.
                        </li>

                        <li>
                            Rossz idő esetén új időpontot
                            egyeztetünk.
                        </li>

                        <li>
                            A beküldött időpont még nem
                            automatikusan elfogadott foglalás.
                        </li>
                    </ul>
                </aside>

                <div class="public-content-card">
                    <h2>Foglalási adatok</h2>

                    <form
                        class="public-form"
                        method="POST"
                        action="{{ route('bookings.store') }}"
                    >
                        @csrf

                        <div class="public-field-full">
                            <label for="name">
                                Teljes név
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old(
                                    'name',
                                    auth()->user()?->name
                                ) }}"
                                autocomplete="name"
                                maxlength="150"
                                required
                            >

                            @error('name')
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
                                maxlength="30"
                                required
                            >

                            @error('phone')
                                <p class="public-field-error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="visit_date">
                                Látogatás napja
                            </label>

                            <input
                                type="date"
                                id="visit_date"
                                name="visit_date"
                                min="{{ now()->toDateString() }}"
                                value="{{ old('visit_date') }}"
                                required
                            >

                            @error('visit_date')
                                <p class="public-field-error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="visit_time">
                                Érkezés időpontja
                            </label>

                            <select
                                id="visit_time"
                                name="visit_time"
                                required
                            >
                                <option value="">
                                    Válassz időpontot
                                </option>

                                @foreach (['10:00', '12:00', '14:00', '16:00'] as $time)
                                    <option
                                        value="{{ $time }}"
                                        @selected(old('visit_time') === $time)
                                    >
                                        {{ $time }}
                                    </option>
                                @endforeach
                            </select>

                            @error('visit_time')
                                <p class="public-field-error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="public-field-full">
                            <label for="guests">
                                Látogatók száma
                            </label>

                            <input
                                type="number"
                                id="guests"
                                name="guests"
                                min="1"
                                max="10"
                                value="{{ old('guests', 1) }}"
                                required
                            >

                            @error('guests')
                                <p class="public-field-error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="public-field-full">
                            <label for="message">
                                Megjegyzés
                            </label>

                            <textarea
                                id="message"
                                name="message"
                                placeholder="Például: kisgyerekkel érkezünk, vagy más fontos információ"
                                maxlength="2000"
                                >{{ old('message') }}</textarea>

                            @error('message')
                                <p class="public-field-error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button
                            class="public-button"
                            type="submit"
                        >
                            Foglalási igény elküldése
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>