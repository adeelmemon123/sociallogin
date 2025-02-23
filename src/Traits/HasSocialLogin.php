<?php

namespace Adeelmemon\SocialLogin\Traits;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;


trait HasSocialLogin
{

    public static function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public static function handleProviderCallback($provider)
    {
        try {

            $socialUser = Socialite::driver($provider)->stateless()->user();

            $user = self::where('email', $socialUser->getEmail())->first();

        if ($user) {
            $user->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        }
        else {
            $user = self::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'avatar' => $socialUser->getAvatar(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'password' => bcrypt(uniqid()),
                'email_verified_at' => now(),
            ]);
        }

            Auth::login($user);

            return redirect('/')->with('success', 'Logged in successfully!');


        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Authentication failed: ' . $e->getMessage());
        }
    }
}
