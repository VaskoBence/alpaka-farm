<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_product_with_image(): void
    {
        Storage::fake('public');

        $this->actingAs(
            $this->createAdmin()
        );

        $response = $this->post(
            route('admin.products.store'),
            [
                ...$this->validProductData(),
                'image' => $this->fakePng(),
            ]
        );

        $response
            ->assertRedirect(
                route('admin.products.index')
            )
            ->assertSessionHas('success');

        $product = Product::query()
            ->firstOrFail();

        $this->assertSame(
            'uj-alpaka-bogre',
            $product->slug
        );

        $this->assertTrue(
            $product->is_active
        );

        Storage::disk('public')
            ->assertExists(
                $product->image_path
            );
    }

    public function test_admin_can_update_product_and_replace_image(): void
    {
        Storage::fake('public');

        Storage::disk('public')->put(
            'products/regi.png',
            'old'
        );

        $product = Product::create([
            ...$this->validProductData(),
            'slug' => 'uj-alpaka-bogre',
            'image_path' =>
                'products/regi.png',
        ]);

        $this->actingAs(
            $this->createAdmin()
        );

        $response = $this->put(
            route(
                'admin.products.update',
                $product
            ),
            [
                ...$this->validProductData(),
                'name' =>
                    'Módosított alpaka bögre',
                'image' => $this->fakePng(),
            ]
        );

        $response->assertRedirect(
            route('admin.products.index')
        );

        $product->refresh();

        $this->assertSame(
            'modositott-alpaka-bogre',
            $product->slug
        );

        Storage::disk('public')
            ->assertMissing(
                'products/regi.png'
            );

        Storage::disk('public')
            ->assertExists(
                $product->image_path
            );
    }

    public function test_unused_admin_show_route_is_not_registered(): void
    {
        $this->assertFalse(
            Route::has('admin.products.show')
        );
    }

    public function test_different_names_cannot_generate_same_slug(): void
    {
        Product::create([
            ...$this->validProductData(),
            'name' => 'Al-paka bögre',
            'slug' => 'al-paka-bogre',
        ]);

        $this->actingAs(
            $this->createAdmin()
        )->post(
            route('admin.products.store'),
            [
                ...$this->validProductData(),
                'name' => 'Al paka bögre',
            ]
        )->assertSessionHasErrors('slug');

        $this->assertDatabaseCount(
            'products',
            1
        );
    }

    public function test_symbol_only_name_has_no_redundant_slug_error(): void
    {
        $response = $this->actingAs(
            $this->createAdmin()
        )->post(
            route('admin.products.store'),
            [
                ...$this->validProductData(),
                'name' => '!!!',
            ]
        );

        $response
            ->assertSessionHasErrors('name')
            ->assertSessionDoesntHaveErrors(
                'slug'
            );

        $this->assertDatabaseCount(
            'products',
            0
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
     * @return array<string, mixed>
     */
    private function validProductData(): array
    {
        return [
            'name' => 'Új alpaka bögre',
            'description' =>
                'Egy teszttermék leírása.',
            'price' => 3990,
            'stock' => 8,
            'is_active' => '1',
        ];
    }

    private function fakePng(): UploadedFile
    {
        return new UploadedFile(
            public_path(
                'images/alpaka-logo.png'
            ),
            'termek.png',
            'image/png',
            null,
            true
        );
    }
}