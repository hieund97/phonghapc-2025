<?php

namespace Ladifire\LaravelPayment\Contracts;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

interface Result
{
    /**
     * Check result is redirect or not.
     *
     * @return bool
     */
    public function isRedirect(): bool;

    /**
     * Redirect user to the redirect url.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect(): RedirectResponse;

    /**
     * Get the redirect url of the result.
     *
     * @return string
     */
    public function getRedirectUrl(): ?string;

    /**
     * Get the provider order id of the result.
     *
     * @return string|null
     */
    public function getProviderOrderId(): ?string;

    /**
     * Get the order id of the result.
     *
     * @return string
     */
    public function getOrderId(): string;

    /**
     * Get the status of the result.
     *
     * @return integer
     */
    public function getStatus(): int;

    /**
     * Get the message of the result.
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Get the transaction time of the result.
     *
     * @return \Illuminate\Support\Carbon|null
     */
    public function getTransactionTime(): ?Carbon;

    /**
     * Get the transaction success time of the result.
     *
     * @return \Illuminate\Support\Carbon|null
     */
    public function getSuccessTime(): ?Carbon;

    /**
     * Get the amount of the result.
     *
     * @return integer
     */
    public function getAmount(): int;

    /**
     * Get the fee of the result.
     *
     * @return float
     */
    public function getFee(): float;
}
