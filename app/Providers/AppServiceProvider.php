<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Strategies\PricingStrategyInterface;
use App\Strategies\StandardPricingStrategy; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PricingStrategyInterface::class, StandardPricingStrategy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
