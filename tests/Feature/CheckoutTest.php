<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_creates_order_and_decrements_stock(): void
    {
        $product = $this->createProduct();

        $response = $this
            ->withSession([
                'cart' => [
                    $product->id => 2,
                ],
            ])
            ->post(
                route('checkout.store'),
                $this->validOrderData()
            );

        $response
            ->assertRedirect(
                route('checkout.success')
            )
            ->assertSessionHas('order_id')
            ->assertSessionMissing('cart');

        $this->assertDatabaseHas('orders', [
            'email' => 'vasarlo@example.com',
            'total_price' => 15980,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas(
            'order_items',
            [
                'product_id' => $product->id,
                'quantity' => 2,
                'unit_price' => 7990,
                'line_total' => 15980,
            ]
        );

        $this->assertSame(
            3,
            $product->refresh()->stock
        );
    }

    public function test_checkout_rejects_insufficient_stock_atomically(): void
    {
        $product = $this->createProduct([
            'stock' => 1,
        ]);

        $response = $this
            ->withSession([
                'cart' => [
                    $product->id => 2,
                ],
            ])
            ->post(
                route('checkout.store'),
                $this->validOrderData()
            );

        $response->assertSessionHasErrors(
            'cart'
        );

        $this->assertDatabaseCount(
            'orders',
            0
        );

        $this->assertSame(
            1,
            $product->refresh()->stock
        );
    }

    public function test_checkout_rejects_inactive_product(): void
    {
        $product = $this->createProduct([
            'is_active' => false,
        ]);

        $response = $this
            ->withSession([
                'cart' => [
                    $product->id => 1,
                ],
            ])
            ->post(
                route('checkout.store'),
                $this->validOrderData()
            );

        $response->assertSessionHasErrors(
            'cart'
        );

        $this->assertDatabaseCount(
            'orders',
            0
        );

        $this->assertSame(
            5,
            $product->refresh()->stock
        );
    }

    public function test_checkout_rejects_invalid_session_quantity(): void
    {
        $product = $this->createProduct();

        $response = $this
            ->withSession([
                'cart' => [
                    $product->id => 'hibas',
                ],
            ])
            ->post(
                route('checkout.store'),
                $this->validOrderData()
            );

        $response->assertSessionHasErrors(
            'cart'
        );

        $this->assertDatabaseCount(
            'orders',
            0
        );

        $this->assertSame(
            5,
            $product->refresh()->stock
        );
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

    /**
     * @return array<string, string>
     */
    private function validOrderData(): array
    {
        return [
            'customer_name' => 'Teszt Vásárló',
            'email' => 'vasarlo@example.com',
            'phone' => '+36 30 111 2233',
            'postal_code' => '2000',
            'city' => 'Mintaváros',
            'address' => 'Minta köz 1.',
            'payment_method' =>
                'cash_on_delivery',
        ];
    }
}