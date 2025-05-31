<?php

namespace App\Models;

use App\Traits\HasLogs;
use Carbon\Carbon;
use DB;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Tags\HasTags;
use Yadakhov\InsertOnDuplicateKey;

class Product extends Model
{
    use Filterable, SearchableTrait, Searchable, InsertOnDuplicateKey, HasTags, HasLogs, SoftDeletes;

    public static $cacheTags = 'products';
    public static $hiddenByStatus = [2];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'suffix',
        'type',
        'price',
        'hide_price_label',
        'sale_price',
        'sale_from',
        'sale_to',
        'hide_sale_time',
        'serial',
        'brand_id',
        'technical_specification',
        'description',
        'feature_img',
        'real_images',
        'show_on_top',
        'include_in_box',
        'pin_to_top',
        'slug',
        'status',
        'status_note',
        'status_note_color',
        'product_category_id',
        'warranty',
        'skus',
        'rate_star',
        'rate_count',
        'url_old',
        'published_at',
        'rate_count',
        'rate_star',
        'banner',
        'author',
        'outstanding_features',
        'gift_product',
        'view_count',
        'config',
        'is_border',
        'border_image'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'hide_sale_time' => 'boolean',
        'thumbnail'      => 'array',
        'real_images'    => 'array',
        'show_on_top'    => 'boolean',
        'pin_to_top'     => 'boolean',
        'not_for_sale'   => 'boolean',
        'include_in_box' => 'array',
        'config'        => 'array',
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'name' => 10,
        ],
    ];

    protected $appends = [];

    protected $with = [
        'productMedias.mediaFile',
    ];

    public static function ignoreGlobalEagerLoading()
    {
        return (new static)->newQueryWithoutScopes(true);
    }

    /**
     * Get a new query builder that doesn't have any global scopes.
     *
     * @param bool $ignoreEagerLoading
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newQueryWithoutScopes($ignoreEagerLoading = false)
    {
        if ($ignoreEagerLoading) {
            return $this->newModelQuery();
        }

        return $this->newModelQuery()->with($this->with)->withCount($this->withCount);
    }

    /**
     * Get the auto increment value of this table.
     *
     * @return int
     */
    public static function getIncrementValue(): int
    {
        $statement = DB::select("show table status like '" . (new static())->getTable() . "'");

        return $statement[0]->Auto_increment;
    }

    static public function inSaleTime()
    {
        $instance = new static;

        return $instance->where(function (Builder $query) {
            $query->where('sale_from', '<=', now());
            $query->where('sale_to', '>=', now());
        });
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('enabled', function (Builder $builder) {
            $builder->whereNotIn('status', static::$hiddenByStatus);
        });

        //static::addGlobalScope('published', function (Builder $builder) {
        //    $builder->where('published_at', '<=', Carbon::now()->toDateTimeString());
        //});
    }

    /**
     * Get the page's seo meta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'model', 'model', 'model_id');
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs(): string
    {
        return 'ecommerce_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        $terms = collect([]);
        $terms = $terms->push($slug = Str::slug($this->name, ' '));
        $terms = $terms->merge($this->tags->pluck('name')->toArray());
        //$terms = $terms->merge(explode(' ', $slug));

        foreach (explode(' ', $slug) as $term) {
            if (strlen($term) < 3) {
                continue;
            }

            if (strlen($term) < 6) {
                $terms = $terms->push(str_replace(' ', '', $term));
            }
        }

        return [
            'completion_name'  => $slug,
            'completion_terms' => $terms->unique()->filter()->toArray(),
            'type'             => $this->type,
        ];
    }

    /**
     * Scope a query to get active products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param bool                                  $ignoreVisible
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsEnable($query, $ignoreVisible = false)
    {
        return $query;
    }

    /**
     * Scope a query to include attributes of a given product categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $productCategoryId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByProductCategoryId($query, $productCategoryId): Builder
    {
        $productCategory = ProductCategory::ancestorsOf($productCategoryId)
                                          ->merge(ProductCategory::descendantsAndSelf($productCategoryId))
        ;

        return $query->whereIn('product_category_id', $productCategory->pluck('id')->toArray());
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the product category of the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class, 'model_id')->where('model', static::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productMedias(): HasMany
    {
        return $this->hasMany(ProductMedia::class, 'model_id')->where('model', static::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function realImages(): HasMany
    {
        return $this->hasMany(RealImage::class, 'model_id')->where('model', static::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function relates(): BelongsToMany
    {
        return $this->belongsToMany(static::class, 'product_relates', 'product_id',
            'relate_id')->withPivot('sort')->orderBy('sort');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function similars(): BelongsToMany
    {
        return $this->belongsToMany(static::class, 'product_similars', 'product_id',
            'similar_id')->withPivot('sort')->orderBy('sort');
    }


    public function getRealPriceAttribute()
    {
        if ($this->isSale()) {
            return $this->sale_price;
        }

        return $this->price;
    }

    public function getPriceSaleOrNot()
    {
        if ($this->sale_price == 0 || $this->sale_price == null) {
            return $this->price;
        } else {
            return $this->sale_price;
        }
    }

    public function isSale()
    {
        $now = now();
        if (!empty($this->sale_price)) {
            if (empty($this->sale_from) && empty($this->sale_to)) {
                return true;
            }
            if ($this->sale_from <= $now && $this->sale_to >= $now) {
                return true;
            }
        }

        return false;
    }

    public function salePercent()
    {
        if ($this->isSale()) {
            return '-' . round(($this->price - $this->sale_price) * 100 / ($this->price)) . '%';
        }

        return '';
    }

    public function labelStatus($value = '')
    {
        if ($value) {
            if (!empty(config('admin.product_status')[$value])) {
                return 'products.status.' . config('admin.product_status')[$value];
            } else {
                return 'Unknown';
            }
        }

        if (!empty(config('admin.product_status')[$this->status])) {
            return 'products.status.' . config('admin.product_status')[$this->status];
        } else {
            return 'Unknown';
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getReviewAverage()
    {
        $reviews = $this->reviews;
        if ($reviews->count() > 0) {
        }
    }

    public function getReviewHasApproved()
    {
        return $this->hasMany(Review::class)->where(function (Builder $query) {
            $query->whereNull('publish_at')->orWhere('publish_at', '<=', now());
        })->where('approved', 1);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_products');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'product_category');
    }

    public function productTags(): BelongsToMany
    {
        return $this->belongsToMany(ProductTag::class, 'product_tag');
    }

    protected function getNumbers($str)
    {
        preg_match_all('/\d+/', $str, $matches);

        return $matches[0];
    }

    public function attribute(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_relationships', 'product_id', 'attr_id');
    }

    /**
     * Get the user that owns the phone.
     */
    public function crawl()
    {
        return $this->belongsTo(CrawlReport::class, 'product_id', 'id');
    }
}
