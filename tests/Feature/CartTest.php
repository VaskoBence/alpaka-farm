<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_product_can_be_added_to_cart(): void
    {
        $product = $this->createProduct();

        $response = $this->post(
            route('cart.store', $product),
            [
                'quantity' => 2,
            ]
        );

        $response
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas(
                "cart.{$product->id}",
                2
            );
    }

    public function test_inactive_product_cannot_be_added_or_updated(): void
    {
        $product = $this->createProduct([
            'is_active' => false,
        ]);

        $this->post(
            route('cart.store', $product),
            [
                'quantity' => 1,
            ]
        )->assertNotFound();

        $this->withSession([
            'cart' => [
                $product->id => 1,
            ],
        ])->patch(
            route('cart.update', $product),
            [
                'quantity' => 1,
            ]
        )->assertNotFound();
    }

    public function test_update_does_not_create_missing_cart_item(): void
    {
        $product = $this->createProduct();

        $response = $this->patch(
            route('cart.update', $product),
            [
                'quantity' => 1,
            ]
        );

        $response
            ->assertRedirect(route('cart.index'))
            ->assertSessionHasErrors('cart');
    }

    public function test_checkout_link_is_hidden_for_unavailable_item(): void
    {
        $product = $this->createProduct([
            'is_active' => false,
        ]);

        $this->withSession([
            'cart' => [
                $product->id => 1,
            ],
        ])->get(route('cart.index'))
            ->assertOk()
            ->assertSeeText(
                'Ez a termék már nem rendelhető.'
            )
            ->assertDontSee(
                'Tovább a pénztárhoz'
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
}