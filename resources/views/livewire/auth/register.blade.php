<x-layouts::auth title="Regisztráció">
    <div class="auth-card">
        <header class="auth-card-header">
            <h1>Fiók létrehozása</h1>

            <p>
                Regisztrálj rendeléseid és foglalásaid követéséhez.
            </p>
        </header>

        <form
            class="auth-form"
            method="POST"
            action="{{ route('register.store') }}"
        >
            @csrf

            <div class="auth-field">
                <label for="name">
                    Teljes név
                </label>

                <input
                    class="auth-input @error('name') auth-input-error @enderror"
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Vezetéknév Keresztnév"
                    autocomplete="name"
                    required
                    autofocus
                >

                @error('name')
                    <p class="auth-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="auth-field">
                <label for="email">
                    E-mail-cím
                </label>

                <input
                    class="auth-input @error('email') auth-input-error @enderror"
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="pelda@email.hu"
                    autocomplete="email"
                    required
                >

                @error('email')
                    <p class="auth-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="auth-field">
                <label for="password">
                    Jelszó
                </label>

                <input
                    class="auth-input @error('password') auth-input-error @enderror"
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Válassz biztonságos jelszót"
                    autocomplete="new-password"
                    required
                >

                @error('password')
                    <p class="auth-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="auth-field">
                <label for="password_confirmation">
                    Jelszó megerősítése
                </label>

                <input
                    class="auth-input"
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Írd be ismét a jelszót"
                    autocomplete="new-password"
                    required
                >
            </div>

            <button
                class="auth-submit"
                type="submit"
                data-test="register-user-button"
            >
                Regisztráció
            </button>
        </form>

        <p class="auth-footer">
            Már van fiókod?

            <a
                class="auth-link"
                href="{{ route('login') }}"
            >
                Bejelentkezés
            </a>
        </p>
    </div>
</x-layouts::auth>