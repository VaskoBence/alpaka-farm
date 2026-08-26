<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),

            'pendingBookingCount' =>
                Booking::query()
                    ->where('status', 'pending')
                    ->count(),

            'pendingOrderCount' =>
                Order::query()
                    ->where('status', 'pending')
                    ->count(),

            'latestOrders' =>
                Order::query()
                    ->with('items')
                    ->orderByDesc('created_at')
                    ->limit(5)
                    ->get(),

            'upcomingBookings' =>
                Booking::query()
                    ->whereDate(
                        'visit_date',
                        '>=',
                        today()
                    )
                    ->where(
                        'status',
                        '!=',
                        'cancelled'
                    )
                    ->orderBy('visit_date')
                    ->orderBy('visit_time')
                    ->limit(5)
                    ->get(),
        ]);
    }
}