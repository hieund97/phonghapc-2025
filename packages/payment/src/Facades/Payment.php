<?php

namespace Ladifire\LaravelPayment\Facades;

use Illuminate\Support\Facades\Facade;
use Ladifire\LaravelPayment\Contracts\Factory;
use Ladifire\LaravelPayment\Contracts\Provider;

/**
 * @method static Provider driver(string $driver = null)
 * @see \Ladifire\LaravelPayment\PaymentManager
 */
class Payment extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return Factory::class;
    }
}
