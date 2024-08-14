<?php

namespace App\Providers;

use App\Service\Auth\JwtGuard;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Auth::extend('jwt', function (Application $app, string $name, array $config) {
            $instance = new JwtGuard(
                $app->make('request')
            );
            $instance->setProvider(Auth::createUserProvider($config['provider']) ?? null);

            return $instance;
        });
    }
}
