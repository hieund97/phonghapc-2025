<?php

namespace App\Models;

use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\Request;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Tags\HasTags;

class Post extends Model
{
    use Filterable, SearchableTrait, HasTags;
    use HasFactory;

    public const STATUS = [
        1 => 'publish',
        2 => 'pending',
        3 => 'draft',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'product_category_id',
        'content',
        'excerpt',
        'thumbnail',
        'banner',
        'slug',
        'author',
        'status',
        'sort',
        'is_featured',
        'is_experience',
        'is_home_featured',
        'is_event',
        'is_video',
        'published_at',
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'title' => 10,
            'content' => 5,
            'excerpt' => 1,
        ],
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_experience' => 'boolean',
        'is_video' => 'boolean',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

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
     * Get the page's seo meta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    // public function itemRelates(): MorphToMany
    // {
    //     return $this->morphToMany(ItemRelate::class, 'model', 'model', 'model_id');
    // }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'post_products', 'post_id', 'product_id');
    }

    public function scopeSortBy(Builder $query, Request $request)
    {
        $sortType = $request->get('sort_type', 'last_update');
        $sortDirection = $request->get('sort_direction', 'desc');

        if ($sortType == 'view') {
            return $query->orderBy('views_count', $sortDirection);
        }

        $columns = [
            'last_update' => 'id',
            'featured' => 'is_featured',
        ];

        return $query->orderBy('sort', 'desc')->orderBy($columns[$sortType], $sortDirection);
    }

    public function postTags(): BelongsToMany
    {
        return $this->belongsToMany(PostTag::class, 'post_tag');
    }


}
