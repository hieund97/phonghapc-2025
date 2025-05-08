<?php

namespace App\Models;

use App\Traits\ForgetResponseCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;
use Nicolaslopezj\Searchable\SearchableTrait;

class Brand extends Model
{
    use SearchableTrait, ForgetResponseCache;

    public static $cacheTags = 'brands';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'product_category_id',
        'slug',
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'title' => 5,
        ],
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saved(function ($brand) {
            Cache::forget('all_brands');
            Cache::forever('all_brands', static::all());
        });
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * The filter product categories that belong to the brand.
     */
    public function filterProductCategories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class)
            ->using(ProductCategoryBrand::class)
            ->withPivot([
                'slug',
                'title',
                'description',
                'created_at',
                'updated_at',
            ]);
    }
}
