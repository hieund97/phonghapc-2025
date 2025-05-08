<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'phone_number',
        'address',
        'street',
        'ward',
        'district',
        'province',
        'country',
        'addressable_id',
        'addressable_type',
    ];

    /**
     * Get the owning addressable model.
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    public function provinceDetail(): BelongsTo
    {
        return $this->belongsTo(Province::class,'province');
    }

    public function districtDetail(): BelongsTo
    {
        return $this->belongsto(District::class,'district');
    }

    public function wardDetail(): BelongsTo
    {
        return $this->belongsTo(Ward::class,'ward');
    }
}
