<?php

namespace App\Models;

use App\Traits\ForgetResponseCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Slider extends Model
{
    use SearchableTrait, ForgetResponseCache;

    public static $cacheTags = 'sliders';

    public const TYPE_DESKTOP = 1;
    public const TYPE_MOBILE = 2;

    public const MODEL = [
        'Home',
        ProductCategory::class,
        Category::class,
        ProductTag::class,
        PostTag::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'info',
        'thumbnail',
        'link',
        'type',
        'sort',
        'model',
        'model_id',
        'status',
        'target',
        'rel',
        'description'
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'title' => 1,
        ],
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'model_id');
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'model_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'model_id');
    }

    public function productTag(): BelongsTo
    {
        return $this->belongsTo(ProductTag::class, 'model_id');
    }

    public function postTag(): BelongsTo
    {
        return $this->belongsTo(PostTag::class, 'model_id');
    }

    ///**
    // * @return \Illuminate\Database\Eloquent\Relations\HasMany
    // */
    //public function sliderMedias(): HasMany
    //{
    //    return $this->hasMany(SliderMedia::class, 'model_id');
    //}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productMedias(): HasMany
    {
        return $this->hasMany(ProductMedia::class, 'model_id')->where('model', static::class);
    }
}
