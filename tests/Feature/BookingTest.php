<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_booking_for_allowed_time(): void
    {
        $response = $this->post(
            route('bookings.store'),
            $this->validBookingData()
        );

        $response
            ->assertRedirect(
                route('bookings.create')
            )
            ->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [
            'email' => 'vendeg@example.com',
            'guests' => 2,
            'status' => 'pending',
            'user_id' => null,
        ]);
    }

    public function test_only_configured_times_are_accepted(): void
    {
        $response = $this->post(
            route('bookings.store'),
            $this->validBookingData([
                'visit_time' => '11:00',
            ])
        );

        $response->assertSessionHasErrors(
            'visit_time'
        );

        $this->assertDatabaseCount(
            'bookings',
            0
        );
    }

    public function test_time_slot_cannot_exceed_ten_guests(): void
    {
        Booking::create(
            $this->validBookingData([
                'guests' => 8,
                'status' => 'confirmed',
            ])
        );

        $response = $this->post(
            route('bookings.store'),
            $this->validBookingData([
                'email' => 'masik@example.com',
                'guests' => 3,
            ])
        );

        $response->assertSessionHasErrors(
            'guests'
        );

        $this->assertDatabaseCount(
            'bookings',
            1
        );
    }

    public function test_cancelled_booking_does_not_use_capacity(): void
    {
        Booking::create(
            $this->validBookingData([
                'guests' => 10,
                'status' => 'cancelled',
            ])
        );

        $response = $this->post(
            route('bookings.store'),
            $this->validBookingData([
                'email' => 'uj@example.com',
                'guests' => 10,
            ])
        );

        $response
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseCount(
            'bookings',
            2
        );
    }

    public function test_authenticated_booking_is_attached_to_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(
            route('bookings.store'),
            $this->validBookingData()
        );

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'email' => 'vendeg@example.com',
        ]);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function validBookingData(
        array $overrides = []
    ): array {
        return array_merge([
            'name' => 'Teszt Vendég',
            'email' => 'vendeg@example.com',
            'phone' => '+36 30 111 2233',
            'visit_date' =>
                today()->addDay()->toDateString(),
            'visit_time' => '10:00',
            'guests' => 2,
            'message' => 'Teszt foglalás.',
        ], $overrides);
    }
}