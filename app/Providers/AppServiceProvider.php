<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind members repository
        $this->app->singleton(
            \App\Repositories\Members\MembersRepositoryInterface::class,
            \App\Repositories\Members\MembersRepository::class
        );

        // Bind projects repository
        $this->app->singleton(
            \App\Repositories\Projects\ProjectsRepositoryInterface::class,
            \App\Repositories\Projects\ProjectsRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
