<?php

declare(strict_types = 1);

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Override;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configModels();
        $this->configCommands();
        $this->configUrls();
        $this->configDate();
        $this->configRateLimiting();
        $this->configObservers();
    }

    /**
     * Configures Eloquent models by disabling the requirement for defining
     * the fillable property and enforcing strict checking to ensure that
     * all accessed properties exist within the model.
     */
    private function configModels(): void
    {
        // --
        // Remove the need of the property fillable on each model
        Model::unguard();

        // --
        // Make sure that all properties being called exists in the model
        // Model::shouldBeStrict();
    }

    /**
     * Configures database commands to prohibit execution of destructive statements
     * when the application is running in a production environment.
     */
    private function configCommands(): void
    {
        DB::prohibitDestructiveCommands(
            app()->isProduction()
        );
    }

    /**
     * Configures the application URLs to enforce HTTPS protocol for all routes.
     */
    private function configUrls(): void
    {
        if (app()->isProduction()) {
            URL::forceHttps();
        }
    }

    /**
     * Configures the application to use CarbonImmutable for date and time handling.
     */
    private function configDate(): void
    {
        Date::use(CarbonImmutable::class);
    }

    /**
     * Configures rate limiting for various application endpoints.
     */
    private function configRateLimiting(): void
    {
        RateLimiter::for('register', function ($request) {
            return Limit::perMinute(1)->by($request->email);
        });

        RateLimiter::for('login', function ($request) {
            return Limit::perMinute(5)->by($request->email);
        });

        RateLimiter::for('api', function ($request) {
            $user = $request->user();

            // Limitação da api diferente com base no perfil do usuário
            if ($user) {
                if ($user->isAdmin()) {
                    return Limit::perMinute(120)->by($user->id);
                } elseif ($user->isManager()) {
                    return Limit::perMinute(90)->by($user->id);
                }

                return Limit::perMinute(60)->by($user->id);
            }

            return Limit::perMinute(30)->by($request->ip());
        });

        // Limitação de requisições para criação de tarefas
        RateLimiter::for('task-creation', function ($request) {
            $user = $request->user();

            if ($user) {
                if ($user->isAdmin()) {
                    return Limit::perMinute(30)->by($user->id);
                } elseif ($user->isManager()) {
                    return Limit::perMinute(20)->by($user->id);
                }

                return Limit::perMinute(10)->by($user->id);
            }

            return Limit::perMinute(5)->by($request->ip());
        });
    }

    /**
     * Register model observers.
     */
    private function configObservers(): void
    {
        \App\Models\Task::observe(\App\Observers\TaskObserver::class);
    }
}
