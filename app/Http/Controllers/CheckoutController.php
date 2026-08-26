<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(Request $request): View
    {
        $storedCart = $request
            ->session()
            ->get('cart', []);

        $cart = is_array($storedCart)
            ? $storedCart
            : [];

        $products = Product::query()
            ->whereIn('id', array_keys($cart))
            ->where('is_active', true)
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

        return view('checkout.create', [
            'items' => $items,
            'total' => $items->sum('subtotal'),
        ]);
    }

    public function store(
        StoreOrderRequest $request
    ): RedirectResponse
    {
        $storedCart = $request
            ->session()
            ->get('cart', []);

        $cart = is_array($storedCart)
            ? $storedCart
            : [];

        if ($cart === []) {
            return redirect()
                ->route('cart.index')
                ->withErrors([
                    'cart' => 'A kosár üres.',
                ]);
        }

        $validated = $request->validated();

        $user = $request->user();

        $userId = $user instanceof User
            ? $user->getKey()
            : null;

        $order = DB::transaction(
            function () use (
                $cart,
                $validated,
                $userId
            ) {
                $products = Product::query()
                    ->whereIn(
                        'id',
                        array_keys($cart)
                    )
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                $total = 0;

                /**
                 * @var array<int, array{
                 *     product: Product,
                 *     quantity: int,
                 *     line_total: int
                 * }> $orderLines
                 */
                $orderLines = [];

                foreach (
                    $cart as $productId => $quantity
                ) {
                    $quantity = filter_var(
                        $quantity,
                        FILTER_VALIDATE_INT
                    );

                    if (
                        $quantity === false
                        || $quantity < 1
                    ) {
                        throw ValidationException::withMessages([
                            'cart' =>
                                'A kosár hibás mennyiséget tartalmaz.',
                        ]);
                    }

                    $product = $products->get(
                        (int) $productId
                    );

                    if (
                        ! $product
                        || ! $product->is_active
                    ) {
                        throw ValidationException::withMessages([
                            'cart' =>
                                'Az egyik termék már nem rendelhető.',
                        ]);
                    }

                    if ($quantity > $product->stock) {
                        throw ValidationException::withMessages([
                            'cart' =>
                                "A(z) {$product->name} termékből nincs elegendő készlet.",
                        ]);
                    }

                    $lineTotal =
                        $product->price * $quantity;

                    $total += $lineTotal;

                    $orderLines[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'line_total' => $lineTotal,
                    ];
                }

                $order = Order::create([
                    'user_id' => $userId,
                    'customer_name' =>
                        $validated['customer_name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'postal_code' =>
                        $validated['postal_code'],
                    'city' => $validated['city'],
                    'address' =>
                        $validated['address'],
                    'payment_method' =>
                        $validated['payment_method'],
                    'total_price' => $total,
                    'status' => 'pending',
                ]);

                foreach ($orderLines as $line) {
                    $product = $line['product'];
                    $quantity = $line['quantity'];

                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' =>
                            $product->name,
                        'quantity' => $quantity,
                        'unit_price' =>
                            $product->price,
                        'line_total' =>
                            $line['line_total'],
                    ]);

                    $product->decrement(
                        'stock',
                        $quantity
                    );
                }

                return $order;
            }
        );

        $request->session()->forget('cart');

        return redirect()
            ->route('checkout.success')
            ->with('order_id', $order->id);
    }
}