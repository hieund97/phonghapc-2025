<?php

namespace Ladifire\LaravelPayment;

use Illuminate\Support\Manager;
use InvalidArgumentException;
use Ladifire\LaravelPayment\Providers\AlepayProvider;

class PaymentManager extends Manager implements Contracts\Factory
{
    /**
     * Get a driver instance.
     *
     * @param string $driver
     *
     * @return mixed
     */
    public function with($driver)
    {
        return $this->driver($driver);
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function createAlepayDriver()
    {
        $config = $this->container->make('config')['payment.alepay'];

        return $this->buildProvider(AlepayProvider::class, $config);
    }

    /**
     * Build an payment provider instance.
     *
     * @param string $provider
     * @param array  $config
     *
     * @return Contracts\Provider
     */
    public function buildProvider($provider, $config): Contracts\Provider
    {
        return new $provider($config);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        throw new InvalidArgumentException('No payment driver was specified.');
    }
}
