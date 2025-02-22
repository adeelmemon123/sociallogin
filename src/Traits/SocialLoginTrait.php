<?php

namespace Adeelmemon\SocialLogin\Traits;

use Laravel\Socialite\Facades\Socialite;

trait SocialLoginTrait
{
    public static function login($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        return self::updateOrCreate(
            ['provider' => $provider, 'provider_id' => $socialUser->getId()],
            ['name' => $socialUser->getName(), 'email' => $socialUser->getEmail(), 'avatar' => $socialUser->getAvatar()]
        );
    }
}
