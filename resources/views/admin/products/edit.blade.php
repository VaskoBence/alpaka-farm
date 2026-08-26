<x-admin-layout title="Termék szerkesztése">
    <div class="admin-page-header">
        <div>
            <h2>Termék szerkesztése</h2>

            <p>
                {{ $product->name }} adatainak módosítása.
            </p>
        </div>
    </div>

    <div class="admin-form-card">
        <form
            class="admin-form"
            method="POST"
            action="{{ route(
                'admin.products.update',
                $product
            ) }}"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="admin-field admin-field-full">
                <label for="name">Termék neve</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $product->name) }}"
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

                @if ($product->image_path)
                    <div>
                        <p>Jelenlegi kép:</p>

                        <img
                            class="admin-current-image"
                            src="{{ asset(
                                'storage/' . $product->image_path
                            ) }}"
                            alt="{{ $product->name }}"
                        >
                    </div>
                @endif

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small>
                    Ha nem választasz új képet, a jelenlegi
                    kép megmarad. JPG, PNG vagy WebP,
                    legfeljebb 4 MB.
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
                >{{ old(
                    'description',
                    $product->description
                ) }}</textarea>

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
                    value="{{ old('price', $product->price) }}"
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
                    value="{{ old('stock', $product->stock) }}"
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
                        @checked(
                            old(
                                'is_active',
                                $product->is_active
                            )
                        )
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
                    Módosítások mentése
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