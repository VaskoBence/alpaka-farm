<x-layouts::auth title="Bejelentkezés">
    <div class="auth-card">
        <header class="auth-card-header">
            <h1>Bejelentkezés</h1>

            <p>
                Add meg az e-mail-címedet és a jelszavadat.
            </p>
        </header>

        @if (session('status'))
            <div class="auth-alert auth-alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form
            class="auth-form"
            method="POST"
            action="{{ route('login.store') }}"
        >
            @csrf

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
                    autofocus
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
                    placeholder="Add meg a jelszavadat"
                    autocomplete="current-password"
                    required
                >

                @error('password')
                    <p class="auth-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="auth-options">
                <label class="auth-checkbox" for="remember">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        value="1"
                        @checked(old('remember'))
                    >

                    Emlékezz rám
                </label>
            </div>

            <button
                class="auth-submit"
                type="submit"
                data-test="login-button"
            >
                Bejelentkezés
            </button>
        </form>

        <p class="auth-footer">
            Még nincs fiókod?

            <a
                class="auth-link"
                href="{{ route('register') }}"
            >
                Regisztráció
            </a>
        </p>
    </div>
</x-layouts::auth>