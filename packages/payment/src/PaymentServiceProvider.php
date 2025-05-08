<?php

namespace Ladifire\LaravelPayment;

use Illuminate\Support\ServiceProvider;
use Ladifire\LaravelPayment\Contracts\Factory;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/payment.php', 'payment');

        $this->app->singleton(Factory::class, function ($app) {
            return new PaymentManager($app);
        });
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPublishing();
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/payment.php' => config_path('payment.php')], 'payment-config');
        }
    }
}
