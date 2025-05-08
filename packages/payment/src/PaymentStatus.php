<?php

namespace Ladifire\LaravelPayment;

class PaymentStatus
{
    public const SUCCESS = 0;
    public const WAIT = 1;
    public const FAIL = 2;
    public const BAD_REQUEST = 400;
    public const INVALID_CONFIG = 500;
    public const INVALID_RESPONSE = 200;
    public const REDIRECTION = 300;
}
