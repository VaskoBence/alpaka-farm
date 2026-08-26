<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_main_public_pages_are_available(): void
    {
        $this->get(
            route('home')
        )->assertOk();

        $this->get(
            route('about')
        )->assertOk();

        $this->get(
            route('contact')
        )->assertOk();

        $this->get(
            route('products.index')
        )->assertOk();

        $this->get(
            route('bookings.create')
        )->assertOk();

        $this->get(
            route('cart.index')
        )->assertOk();
    }
}