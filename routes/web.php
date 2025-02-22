<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::middleware(['web'])->group(function () {
    Route::get('/auth/{provider}', fn($provider) => Socialite::driver($provider)->redirect())->name('social.redirect');

    Route::get('/auth/{provider}/callback', function ($provider) {
        Auth::login(User::login($provider));
        return redirect('/home')->with('success', 'Logged in successfully!');
    })->name('social.callback');
});

