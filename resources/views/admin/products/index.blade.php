<x-admin-layout title="Termékek">
    <div class="admin-page-header">
        <div>
            <h2>Termékek kezelése</h2>
            <p>Termékek létrehozása, módosítása és törlése.</p>
        </div>

        <a
            class="admin-button"
            href="{{ route('admin.products.create') }}"
        >
            Új termék
        </a>
    </div>

    @if (session('success'))
        <div class="admin-alert admin-alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Kép</th>
                    <th>Név</th>
                    <th>Ár</th>
                    <th>Készlet</th>
                    <th>Állapot</th>
                    <th>Műveletek</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>
                            @if ($product->image_path)
                                <img
                                    class="admin-product-image"
                                    src="{{ asset(
                                        'storage/'
                                        . $product->image_path
                                    ) }}"
                                    alt="{{ $product->name }}"
                                >
                            @else
                                <div class="admin-image-placeholder">
                                    Nincs kép
                                </div>
                            @endif
                        </td>

                        <td>
                            <strong>{{ $product->name }}</strong>
                        </td>

                        <td>
                            {{ number_format(
                                $product->price,
                                0,
                                ',',
                                ' '
                            ) }}
                            Ft
                        </td>

                        <td>{{ $product->stock }} db</td>

                        <td>
                            <span class="admin-status
                                {{ $product->is_active
                                    ? 'admin-status-success'
                                    : 'admin-status-danger' }}"
                            >
                                {{ $product->is_active
                                    ? 'Aktív'
                                    : 'Inaktív' }}
                            </span>
                        </td>

                        <td>
                            <div class="admin-actions">
                                <a
                                    class="admin-button
                                           admin-button-secondary"
                                    href="{{ route(
                                        'admin.products.edit',
                                        $product
                                    ) }}"
                                >
                                    Szerkesztés
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.products.destroy',
                                        $product
                                    ) }}"
                                    onsubmit="return confirm(
                                        'Biztosan törlöd a terméket?'
                                    )"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="admin-button
                                               admin-button-danger"
                                        type="submit"
                                    >
                                        Törlés
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            Még nincs termék.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $products->links() }}
    </div>
</x-admin-layout>