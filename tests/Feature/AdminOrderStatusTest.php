<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_cancelling_and_reactivating_order_updates_stock(): void
    {
        $product = $this->createProduct([
            'stock' => 3,
        ]);

        $order = $this->createOrder(
            $product,
            'pending',
            2
        );

        $this->actingAs(
            $this->createAdmin()
        )->patch(
            route(
                'admin.orders.update',
                $order
            ),
            [
                'status' => 'cancelled',
            ]
        )->assertSessionHas('success');

        $this->assertSame(
            5,
            $product->refresh()->stock
        );

        $this->assertSame(
            'cancelled',
            $order->refresh()->status
        );

        $this->patch(
            route(
                'admin.orders.update',
                $order
            ),
            [
                'status' => 'processing',
            ]
        )->assertSessionHas('success');

        $this->assertSame(
            3,
            $product->refresh()->stock
        );

        $this->assertSame(
            'processing',
            $order->refresh()->status
        );
    }

    public function test_cancelled_order_is_not_reactivated_without_stock(): void
    {
        $product = $this->createProduct([
            'stock' => 1,
        ]);

        $order = $this->createOrder(
            $product,
            'cancelled',
            2
        );

        $response = $this->actingAs(
            $this->createAdmin()
        )->patch(
            route(
                'admin.orders.update',
                $order
            ),
            [
                'status' => 'processing',
            ]
        );

        $response->assertSessionHasErrors(
            'status'
        );

        $this->assertSame(
            1,
            $product->refresh()->stock
        );

        $this->assertSame(
            'cancelled',
            $order->refresh()->status
        );
    }

    private function createAdmin(): User
    {
        $admin = User::factory()->create();

        $admin->forceFill([
            'is_admin' => true,
        ])->save();

        return $admin;
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    private function createProduct(
        array $overrides = []
    ): Product {
        return Product::create(
            array_merge([
                'name' => 'Teszt sál',
                'slug' => 'teszt-sal',
                'description' => 'Teszttermék.',
                'price' => 7990,
                'stock' => 5,
                'is_active' => true,
            ], $overrides)
        );
    }

    private function createOrder(
        Product $product,
        string $status,
        int $quantity
    ): Order {
        $order = Order::create([
            'customer_name' => 'Teszt Vásárló',
            'email' =>
                'vasarlo@example.com',
            'phone' => '+36 30 111 2233',
            'postal_code' => '2000',
            'city' => 'Mintaváros',
            'address' => 'Minta köz 1.',
            'total_price' =>
                $product->price * $quantity,
            'payment_method' =>
                'cash_on_delivery',
            'status' => $status,
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'unit_price' => $product->price,
            'line_total' =>
                $product->price * $quantity,
        ]);

        return $order;
    }
}