<?php

namespace Adeelmemon\SocialLogin;

use Illuminate\Support\ServiceProvider;

class SocialLoginServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sociallogin');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Publish configuration
        $this->publishes([
            __DIR__ . '/../config/sociallogin.php' => config_path('sociallogin.php'),
        ], 'config');

        // Merge config safely to avoid null errors
        if (config('sociallogin') !== null) {
            config([
                'services' => array_merge(config('services', []), config('sociallogin', []))
            ]);
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Adeelmemon\SocialLogin\Console\InstallSocialLogin::class,
            ]);
        }
         // Add missing environment variables automatically
        //    $this->ensureEnvVariables();
    }


    public function register()
    {
        // Merge Configurations
        $this->mergeConfigFrom(
            __DIR__ . '/../config/sociallogin.php', 'sociallogin'
        );
    }


    private function ensureEnvVariables()
    {
        $envPath = base_path('.env');

        if (file_exists($envPath)) {
            $envContent = file_get_contents($envPath);

            $envVariables = [
                'GITHUB_CLIENT_ID' => '',
                'GITHUB_CLIENT_SECRET' => '',
                'GITHUB_REDIRECT_URI' => '',

                'FACEBOOK_CLIENT_ID' => '',
                'FACEBOOK_CLIENT_SECRET' => '',
                'FACEBOOK_REDIRECT_URI' => '',

                'GOOGLE_CLIENT_ID' => '',
                'GOOGLE_CLIENT_SECRET' => '',
                'GOOGLE_REDIRECT_URI' => '',

                'TWITTER_CLIENT_ID' => '',
                'TWITTER_CLIENT_SECRET' => '',
                'TWITTER_REDIRECT_URI' => '',

                'LINKEDIN_CLIENT_ID' => '',
                'LINKEDIN_CLIENT_SECRET' => '',
                'LINKEDIN_REDIRECT_URI' => '',

                'INSTAGRAM_CLIENT_ID' => '',
                'INSTAGRAM_CLIENT_SECRET' => '',
                'INSTAGRAM_REDIRECT_URI' => '',
            ];

            foreach ($envVariables as $key => $value) {
                // Check if the variable already exists
                if (preg_match("/^{$key}=.*/m", $envContent)) {
                    // Replace existing value (if any)
                    $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
                } else {
                    // Append new variable if not found
                    $envContent .= PHP_EOL . "{$key}={$value}";
                }
            }

            file_put_contents($envPath, $envContent);
        }
    }

}
