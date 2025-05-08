<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Order extends Model
{
    public static $ORDERSTATUS = [
        1 => 'Deleted',
        2 => 'New',
        3 => 'Processing',
        4 => 'Cancel',
        5 => 'Success',
        6 => 'Unpaid',
        7 => 'Paid',
        8 => 'PaymentFailed',
    ];

    /* */
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_mobile',
        'customer_id_card',
        'customer_id_card_image',
        'customer_amount_installment',
        //'customer_address',
        'customer_note',
        'note',
        'total_price',
        'total_payment_price',
        'bundle_saving',
        'extra_price',
        'extra_name',
        'coupon_code',
        'thumbnail',
        'status',
        'payment_method',
        'provider_order_id',
        'provider_message',
    ];

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_products');
    }

    /**
     * Get the order's address.
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function getCustomerAddressAttribute()
    {
        if (!empty($this->address)) {
            return collect($this->address->only(['address', 'street', 'ward', 'district', 'province', 'country']))
                ->filter()
                ->values()
                ->implode(', ');
        }

        return $this->attributes['customer_address'] ?? null;
    }
}
