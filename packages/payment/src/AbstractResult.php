<?php

namespace Ladifire\LaravelPayment;

use ArrayAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Ladifire\LaravelPayment\Contracts\Result;

abstract class AbstractResult implements ArrayAccess, Result
{
    /**
     * The redirect url.
     *
     * @var string
     */
    public $redirectUrl;

    /**
     * The provider order id.
     *
     * @var string|null
     */
    public $providerOrderId;

    /**
     * The order id.
     *
     * @var string
     */
    public $orderId;

    /**
     * The status.
     *
     * @var integer
     */
    public $status;

    /**
     * The message.
     *
     * @var string
     */
    public $message;

    /**
     * The transaction time.
     *
     * @var Carbon|null
     */
    public $transactionTime;

    /**
     * The success time.
     *
     * @var Carbon|null
     */
    public $successTime;

    /**
     * The amount.
     *
     * @var integer
     */
    public $amount;

    /**
     * The fee.
     *
     * @var float
     */
    public $fee;

    /**
     * The result raw attributes.
     *
     * @var array
     */
    public $result;

    /**
     * @inheritDoc
     */
    public function isRedirect(): bool
    {
        return !empty($this->redirectUrl);
    }

    /**
     * @inheritDoc
     */
    public function redirect(): RedirectResponse
    {
        return redirect($this->getRedirectUrl());
    }

    /**
     * @inheritDoc
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * @inheritDoc
     */
    public function getProviderOrderId(): ?string
    {
        return $this->providerOrderId;
    }

    /**
     * @inheritDoc
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function getTransactionTime(): ?Carbon
    {
        return $this->transactionTime;
    }

    /**
     * @inheritDoc
     */
    public function getSuccessTime(): ?Carbon
    {
        return $this->successTime;
    }

    /**
     * @inheritDoc
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @inheritDoc
     */
    public function getFee(): float
    {
        return $this->fee;
    }

    /**
     * Get the raw result array.
     *
     * @return array
     */
    public function getRaw(): array
    {
        return $this->result;
    }

    /**
     * Set the raw result array from the provider.
     *
     * @param array $result
     *
     * @return $this
     */
    public function setRaw(array $result): self
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Map the given array onto the result properties.
     *
     * @param array $attributes
     *
     * @return $this
     */
    public function map(array $attributes): self
    {
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->result);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->result[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        $this->result[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        unset($this->result[$offset]);
    }
}
