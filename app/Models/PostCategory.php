<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->BelongsTo(Category::class, 'category_id', 'id');
    }
}
