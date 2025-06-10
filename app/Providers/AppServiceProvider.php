<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Services\Payments\PaymentGatewayFactory;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register(): void
    {
         $this->app->singleton(PaymentGatewayFactory::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
          Schema::defaultStringLength(191);
    }
}
