<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlepayBank extends Model
{
    protected $fillable = [
        'bank_id',
        'installment_id',
        'gateway_mid',
        'code',
        'name',
        'hotline',
        'logo',
        'payment_methods',
        'not_validate_card_expire',
        'note',
    ];

    protected $casts = [
        'payment_methods' => 'array',
        'not_validate_card_expire' => 'boolean',
    ];
}
