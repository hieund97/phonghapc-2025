<?php

namespace Ladifire\LaravelPayment\Contracts;

interface Factory
{
    /**
     * Get an payment provider implementation.
     *
     * @param string $driver
     *
     * @return \Ladifire\LaravelPayment\Contracts\Provider
     */
    public function driver($driver = null);
}
