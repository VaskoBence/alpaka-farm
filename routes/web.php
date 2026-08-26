<?php

use App\Http\Controllers\Admin\BookingController
    as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController
    as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController
    as AdminOrderController;
use App\Http\Controllers\Admin\ProductController
    as AdminProductController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')
    ->name('home');

Route::get(
    '/termekek',
    [ProductController::class, 'index']
)->name('products.index');

Route::get(
    '/termekek/{product}',
    [ProductController::class, 'show']
)->name('products.show');

Route::view('/farmunk', 'pages.about')
    ->name('about');

Route::view('/kapcsolat', 'pages.contact')
    ->name('contact');

Route::middleware('auth')->group(function () {
    Route::get(
        'dashboard',
        DashboardController::class
    )->name('dashboard');

    Route::prefix('admin')
        ->name('admin.')
        ->middleware('admin')
        ->group(function () {
            Route::get(
                '/',
                AdminDashboardController::class
            )->name('dashboard');

            Route::resource(
                'products',
                AdminProductController::class
            )->except(['show']);

            Route::get(
                'bookings',
                [
                    AdminBookingController::class,
                    'index',
                ]
            )->name('bookings.index');

            Route::patch(
                'bookings/{booking}',
                [
                    AdminBookingController::class,
                    'update',
                ]
            )->name('bookings.update');

            Route::get(
                'orders',
                [
                    AdminOrderController::class,
                    'index',
                ]
            )->name('orders.index');

            Route::patch(
                'orders/{order}',
                [
                    AdminOrderController::class,
                    'update',
                ]
            )->name('orders.update');
        });
});

Route::get(
    '/idopontfoglalas',
    [BookingController::class, 'create']
)->name('bookings.create');

Route::post(
    '/idopontfoglalas',
    [BookingController::class, 'store']
)->name('bookings.store');

Route::get(
    '/kosar',
    [CartController::class, 'index']
)->name('cart.index');

Route::post(
    '/kosar/{product}',
    [CartController::class, 'store']
)->name('cart.store');

Route::patch(
    '/kosar/{product}',
    [CartController::class, 'update']
)->name('cart.update');

Route::delete(
    '/kosar/{product}',
    [CartController::class, 'destroy']
)->name('cart.destroy');

Route::get(
    '/penztar',
    [CheckoutController::class, 'create']
)->name('checkout.create');

Route::post(
    '/penztar',
    [CheckoutController::class, 'store']
)->name('checkout.store');

Route::view(
    '/rendeles/sikeres',
    'checkout.success'
)->name('checkout.success');

require __DIR__.'/settings.php';