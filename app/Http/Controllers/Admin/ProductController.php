<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Termékek adminisztrációs listája.
     */
    public function index(): View
    {
        $products = Product::query()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Új termék űrlapja.
     */
    public function create(): View
    {
        return view('admin.products.create');
    }

    /**
     * Új termék mentése.
     */
    public function store(
        StoreProductRequest $request
    ): RedirectResponse
    {
        $validated = $request
            ->safe()
            ->except(['image']);

        $validated['is_active'] =
            $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'A termék sikeresen létrejött.'
            );
    }

    /**
     * Termékszerkesztő űrlap.
     */
    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Termék módosításának mentése.
     */
    public function update(
        UpdateProductRequest $request,
        Product $product
    ): RedirectResponse
    {
        $validated = $request
            ->safe()
            ->except(['image']);

        $validated['is_active'] =
            $request->boolean('is_active');

        $oldImagePath = $product->image_path;

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        $product->update($validated);

        if (
            isset($validated['image_path'])
            && $oldImagePath
        ) {
            Storage::disk('public')
                ->delete($oldImagePath);
        }

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'A termék sikeresen módosítva.'
            );
    }

    /**
     * Termék törlése.
     */
    public function destroy(
        Product $product
    ): RedirectResponse
    {
        $imagePath = $product->image_path;

        $product->delete();

        if ($imagePath) {
            Storage::disk('public')
                ->delete($imagePath);
        }

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'A termék sikeresen törölve lett.'
            );
    }
}