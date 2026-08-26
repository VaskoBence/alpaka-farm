<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin(): void
    {
        $this->get(
            route('admin.dashboard')
        )->assertRedirect(
            route('login')
        );
    }

    public function test_regular_user_cannot_open_admin(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_open_admin_without_email_verification(): void
    {
        $admin = User::factory()
            ->unverified()
            ->create();

        $admin->forceFill([
            'is_admin' => true,
        ])->save();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }
}