<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\ImageOptimizationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Image Optimization Service
        $this->app->singleton(ImageOptimizationService::class);
		$this->app->singleton(SerbianTransliterator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Bootstrap pagination views
        Paginator::useBootstrapFour();
    }
}