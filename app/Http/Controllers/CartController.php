<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $storedCart = $request
            ->session()
            ->get('cart', []);

        $cart = is_array($storedCart)
            ? $storedCart
            : [];

        $products = Product::query()
            ->whereIn('id', array_keys($cart))
            ->get();

        $items = $products->map(
            function (Product $product) use ($cart) {
                $quantity = (int) (
                    $cart[$product->id] ?? 0
                );

                return [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' =>
                        $product->price * $quantity,
                ];
            }
        );

        return view('cart.index', [
            'items' => $items,
            'total' => $items->sum('subtotal'),

            'canCheckout' =>
                $items->isNotEmpty()
                && $items->every(
                    fn (array $item): bool =>
                        $item['product']->is_active
                        && $item['product']->stock
                            >= $item['quantity']
                ),
        ]);
    }

    public function store(
        Request $request,
        Product $product
    ): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:' . $product->stock,
            ],
        ]);

        $storedCart = $request
            ->session()
            ->get('cart', []);

        $cart = is_array($storedCart)
            ? $storedCart
            : [];

        $newQuantity =
            (int) ($cart[$product->id] ?? 0)
            + (int) $validated['quantity'];

        if ($newQuantity > $product->stock) {
            return back()->withErrors([
                'quantity' =>
                    'Nincs ennyi darab készleten.',
            ]);
        }

        $cart[$product->id] = $newQuantity;

        $request->session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'A termék bekerült a kosárba.'
            );
    }

    public function update(
        Request $request,
        Product $product
    ): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $storedCart = $request
            ->session()
            ->get('cart', []);

        $cart = is_array($storedCart)
            ? $storedCart
            : [];

        if (! array_key_exists($product->id, $cart)) {
            return redirect()
                ->route('cart.index')
                ->withErrors([
                    'cart' =>
                        'Ez a termék nincs a kosaradban.',
                ]);
        }

        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:' . $product->stock,
            ],
        ]);

        $cart[$product->id] =
            (int) $validated['quantity'];

        $request->session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'A kosár frissítve.');
    }

    public function destroy(
        Request $request,
        Product $product
    ): RedirectResponse
    {
        $storedCart = $request
            ->session()
            ->get('cart', []);

        $cart = is_array($storedCart)
            ? $storedCart
            : [];

        unset($cart[$product->id]);

        $request->session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'A terméket eltávolítottuk a kosárból.'
            );
    }
}