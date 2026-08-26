<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(
        Request $request
    ): View|RedirectResponse
    {
        $user = $request->user();

        abort_unless(
            $user instanceof User,
            401
        );

        if ($user->is_admin) {
            return redirect()
                ->route('admin.dashboard');
        }

        $orders = $user
            ->orders()
            ->with('items')
            ->orderByDesc('created_at')
            ->get();

        $bookings = $user
            ->bookings()
            ->orderByDesc('visit_date')
            ->orderByDesc('visit_time')
            ->get();

        return view('dashboard', [
            'orders' => $orders,
            'bookings' => $bookings,
        ]);
    }
}