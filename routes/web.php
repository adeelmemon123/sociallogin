<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::middleware(['web'])->group(function () {
    Route::get('auth/oauth/{provider}', fn($provider) => User::redirectToProvider($provider))
        ->name('social');

    Route::get('auth/oauth/{provider}/callback', fn($provider) => User::handleProviderCallback($provider))
        ->name('social.callback');
});
