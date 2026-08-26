<x-admin-layout title="Új termék">
    <div class="admin-page-header">
        <div>
            <h2>Új termék létrehozása</h2>

            <p>
                Add meg az új webshoptermék adatait.
            </p>
        </div>
    </div>

    <div class="admin-form-card">
        <form
            class="admin-form"
            method="POST"
            action="{{ route('admin.products.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="admin-field admin-field-full">
                <label for="name">Termék neve</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    maxlength="150"
                    required
                >

                @error('name')
                    <p class="admin-field-error">
                        {{ $message }}
                    </p>
                @enderror

                @error('slug')
                    <p class="admin-field-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="admin-field admin-field-full">
                <label for="image">Termékkép</label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small>
                    JPG, PNG vagy WebP, legfeljebb 4 MB.
                </small>

                @error('image')
                    <p class="admin-field-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="admin-field admin-field-full">
                <label for="description">Leírás</label>

                <textarea
                    id="description"
                    name="description"
                    maxlength="2000"
                >{{ old('description') }}</textarea>

                @error('description')
                    <p class="admin-field-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="admin-field">
                <label for="price">Ár (Ft)</label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    min="0"
                    value="{{ old('price') }}"
                    required
                >

                @error('price')
                    <p class="admin-field-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="admin-field">
                <label for="stock">Készlet</label>

                <input
                    type="number"
                    id="stock"
                    name="stock"
                    min="0"
                    value="{{ old('stock', 0) }}"
                    required
                >

                @error('stock')
                    <p class="admin-field-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="admin-field admin-field-full">
                <input
                    type="hidden"
                    name="is_active"
                    value="0"
                >

                <label
                    class="admin-actions"
                    for="is_active"
                >
                    <input
                        type="checkbox"
                        id="is_active"
                        name="is_active"
                        value="1"
                        @checked(old('is_active', true))
                    >

                    Aktív termék
                </label>

                @error('is_active')
                    <p class="admin-field-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="admin-form-buttons">
                <button
                    class="admin-button"
                    type="submit"
                >
                    Termék mentése
                </button>

                <a
                    class="admin-button admin-button-secondary"
                    href="{{ route('admin.products.index') }}"
                >
                    Mégse
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>