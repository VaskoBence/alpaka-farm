<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::query()
            ->with('user')
            ->orderBy('visit_date')
            ->orderBy('visit_time')
            ->paginate(20);

        return view('admin.bookings.index', [
            'bookings' => $bookings,
        ]);
    }

    public function update(
        Request $request,
        Booking $booking
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'confirmed',
                    'cancelled',
                ]),
            ],
        ]);

        $booking->update($validated);

        return redirect()
            ->route('admin.bookings.index')
            ->with(
                'success',
                'A foglalás állapota módosítva.'
            );
    }
}