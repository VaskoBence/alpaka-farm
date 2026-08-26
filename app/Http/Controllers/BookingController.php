<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(): View
    {
        return view('bookings.create');
    }

    public function store(
        StoreBookingRequest $request
    ): RedirectResponse
    {
        $validated = $request->validated();

        $user = $request->user();

        $validated['user_id'] =
            $user instanceof User
                ? $user->getKey()
                : null;

        Booking::create($validated);

        return redirect()
            ->route('bookings.create')
            ->with(
                'success',
                'A foglalási igényedet sikeresen elküldtük.'
            );
    }
}