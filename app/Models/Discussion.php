<?php

namespace App\Models;

use App\Traits\ForgetResponseCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discussion extends Model
{
    use ForgetResponseCache;

    public static $cacheTags = ['products', 'reviews'];

    protected $fillable = [
        'body',
        'review_id',
        'publish_at',
        'full_name',
        'approved',
        'email',
        'phone_number',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
    ];

    public function reviews(): BelongsTo
    {
        return $this->BelongsTo(Review::class);
    }
}
