<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    public function wards(): HasMany
    {
        return $this->hasMany(Ward::class);
    }
}
