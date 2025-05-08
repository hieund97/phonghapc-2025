<?php

namespace App\Models;

use App\Traits\ForgetResponseCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    use ForgetResponseCache;

    public static $cacheTags = ['products', 'reviews'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'product_id',
        'rating',
        'approved',
        'count_like',
        'count_dislike',
        'publish_at',
        'full_name',
        'email',
        'phone_number',
        'file',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
        'file' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->BelongsTo(Product::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(ReviewReaction::class);
    }

    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }

    public function getDiscussionHasApproved()
    {
        return $this->hasMany(Discussion::class)->where(function (Builder $query) {
            $query->whereNull('publish_at')->orWhere('publish_at', '<=', now());
        })->where('approved', 1);
    }

    public function getDiscussion()
    {
        return $this->hasMany(Discussion::class)->where(function (Builder $query) {
            $query->whereNull('publish_at')->orWhere('publish_at', '<=', now());
        });
    }
}
