<?php

namespace Adeelmemon\SocialLogin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallSocialLogin extends Command
{
    protected $signature = 'sociallogin:install';
    protected $description = 'Automatically update User model with HasSocialLogin trait and fillable attributes';

    public function handle()
    {
        $userModelPath = app_path('Models/User.php');

        if (!File::exists($userModelPath)) {
            $this->error('User model not found!');
            return;
        }

        $userModel = File::get($userModelPath);

        // Ensure HasSocialLogin trait is imported at the top
        if (!str_contains($userModel, 'use Adeelmemon\SocialLogin\Traits\HasSocialLogin;')) {
            $userModel = str_replace(
                "use Illuminate\Foundation\Auth\User as Authenticatable;",
                "use Illuminate\Foundation\Auth\User as Authenticatable;\nuse Adeelmemon\SocialLogin\Traits\HasSocialLogin;",
                $userModel
            );
        }

        // Ensure trait is used inside the class
        if (!preg_match('/use HasSocialLogin;/', $userModel)) {
            $userModel = preg_replace(
                '/class User extends Authenticatable\s*{/',
                "class User extends Authenticatable {\n    use HasSocialLogin;\n",
                $userModel
            );
        }

        // Ensure $fillable property exists and is placed correctly
        if (!preg_match('/protected\s+\$fillable\s*=\s*\[([^\]]*)\];/', $userModel)) {
            // If $fillable does not exist, add it after the trait
            $userModel = preg_replace(
                '/use HasSocialLogin;\n/',
                "use HasSocialLogin;\n\n    protected \$fillable = ['name', 'email', 'provider', 'provider_id', 'avatar','password','email_verified_at'];\n",
                $userModel
            );
        } else {
            // If $fillable exists, append new fields if missing
            if (!str_contains($userModel, "'provider'")) {
                $fillablePattern = '/protected\s+\$fillable\s*=\s*\[([^\]]*)\];/';

                $newFillable = trim('$1') . ", 'provider', 'provider_id', 'avatar'";
                $userModel = preg_replace($fillablePattern, "protected \$fillable = [$newFillable];", $userModel);
            }
        }

        // Save the updated User model
        File::put($userModelPath, $userModel);

        $this->info('User model updated successfully!');
    }
}
