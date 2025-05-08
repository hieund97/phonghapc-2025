<?php

namespace Ladifire\LaravelPayment\Contracts;

use Illuminate\Http\Request;

interface Provider
{
    /**
     * Make a new purchase.
     *
     * @param array $data
     *
     * @return \Ladifire\LaravelPayment\Contracts\Result
     */
    public function purchase(array $data): Result;

    /**
     * Handle callback from provider.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Ladifire\LaravelPayment\Contracts\Result
     */
    public function handleProviderCallback(Request $request): Result;
}
