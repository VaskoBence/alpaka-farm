<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()
            ->with(['items', 'user'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function update(
        Request $request,
        Order $order
    ): RedirectResponse
    {
        $validated = $request->validate([
            'status' => [
                'required',

                Rule::in([
                    'pending',
                    'processing',
                    'completed',
                    'cancelled',
                ]),
            ],
        ]);

        $newStatus = (string) $validated['status'];

        DB::transaction(
            function () use (
                $order,
                $newStatus
            ): void {
                $lockedOrder = Order::query()
                    ->with('items')
                    ->lockForUpdate()
                    ->findOrFail(
                        $order->getKey()
                    );

                $oldStatus = $lockedOrder->status;

                if ($oldStatus === $newStatus) {
                    return;
                }

                if ($newStatus === 'cancelled') {
                    $this->restoreStock(
                        $lockedOrder
                    );
                } elseif ($oldStatus === 'cancelled') {
                    $this->reserveStock(
                        $lockedOrder
                    );
                }

                $lockedOrder->update([
                    'status' => $newStatus,
                ]);
            }
        );

        return redirect()
            ->route('admin.orders.index')
            ->with(
                'success',
                'A rendelés állapota módosítva.'
            );
    }

    private function restoreStock(
        Order $order
    ): void {
        foreach ($order->items as $item) {
            if (! $item->product_id) {
                continue;
            }

            $product = Product::query()
                ->lockForUpdate()
                ->find($item->product_id);

            $product?->increment(
                'stock',
                $item->quantity
            );
        }
    }

    private function reserveStock(
        Order $order
    ): void {
        foreach ($order->items as $item) {
            $product = $item->product_id
                ? Product::query()
                    ->lockForUpdate()
                    ->find($item->product_id)
                : null;

            if (
                ! $product
                || ! $product->is_active
            ) {
                throw ValidationException::withMessages([
                    'status' =>
                        "A(z) {$item->product_name} termék már nem rendelhető, ezért a rendelés nem aktiválható újra.",
                ]);
            }

            if (
                $product->stock
                < $item->quantity
            ) {
                throw ValidationException::withMessages([
                    'status' =>
                        "A(z) {$item->product_name} termékből nincs elegendő készlet a rendelés újraaktiválásához.",
                ]);
            }

            $product->decrement(
                'stock',
                $item->quantity
            );
        }
    }
}