<?php

namespace App\Providers;

use App\Repositories\Contracts\ModuleRepositoryInterface;
use App\Repositories\Eloquent\ModuleRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind Repository Interfaces → Concrete Implementations
        $this->app->bind(
            ModuleRepositoryInterface::class,
            ModuleRepository::class
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
