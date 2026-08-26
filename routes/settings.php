<?php

use App\Http\Controllers\PasskeyEndpointController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Security;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::redirect(
        'settings',
        'settings/profile'
    );

    Route::livewire(
        'settings/profile',
        Profile::class
    )->name('profile.edit');

    Route::livewire(
        'settings/appearance',
        Appearance::class
    )->name('appearance.edit');

    Route::livewire(
        'settings/security',
        Security::class
    )
        /* @chisel-password-confirmation */
        ->middleware([
            'password.confirm',
        ])
        /* @end-chisel-password-confirmation */
        ->name('security.edit');
});

/* @chisel-passkeys */
Route::get(
    '.well-known/passkey-endpoints',
    PasskeyEndpointController::class
)->name('well-known.passkeys');
/* @end-chisel-passkeys */