<?php

namespace App\Providers;

use App\Services\MoMoPaymentService;
use Illuminate\Support\ServiceProvider;

class MoMoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MoMoPaymentService::class, function ($app) {
            return new MoMoPaymentService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
