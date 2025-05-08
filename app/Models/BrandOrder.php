<?php

namespace App\Models;

use App\Traits\ForgetResponseCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandOrder extends Model
{
    use ForgetResponseCache;

    public static $cacheTags = 'brands';

    protected $fillable = [
        'product_category_id',
        'order',
    ];

    protected $casts = [
        'order' => 'array',
    ];

    public $timestamps = false;

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
